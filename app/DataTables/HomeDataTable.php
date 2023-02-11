<?php

namespace App\DataTables;

use App\Models\UserPackage;
use App\Support\Season;
use Yajra\DataTables\Facades\DataTables;

class HomeDataTable
{
    public function __invoke()
    {
        $userPackages = UserPackage::with([
            'user:users.id,users.name,users.email,users.country_id',
            'user.country:countries.id,countries.nicename,countries.iso',
            'package:packages.id,packages.name',
            'addons:user_package_addons.id,user_package_addons.user_package_id,user_package_addons.name,user_package_addons.count',
            'payments:user_package_payments.id,user_package_payments.user_package_id,user_package_payments.payment_type,user_package_payments.amount',
        ])

        ->where(function ($query) {
            if (request('filter_by_trip')) {
                $query->filterByTrip(request('filter_by_trip'));
            }

            if (request('filter_by_pickup')) {
                $query->filterByPickup(request('filter_by_pickup'));
            }

            if (request('filter_by_date')) {
                $query->filterByDate(request('filter_by_date'));
            }

            if (request('filter_by_guide')) {
                $query->filterByGuide(request('filter_by_guide'));
            }
        })

        ->when(request()->filled('status'), function ($query) {
            $season = Season::getCurrentAndNextSeason();

            return match (request('status')) {
                'ongoing' => $query->where('start_date', '<=', today())->where('end_date', '>=', today()),
                'completed' => $query->where('end_date', '<', today()),
                'completed-current-season' => $query->whereBetween('start_date', [$season['currentSeasonStartDate'], $season['currentSeasonEndDate']])->where('end_date', '<', today()),
                'current-season' => $query->whereBetween('start_date', [$season['currentSeasonStartDate'], $season['currentSeasonEndDate']]),
                'next-season' => $query->whereBetween('start_date', [$season['nextSeasonStartDate'], $season['nextSeasonEndDate']]),
                'solo' => $query->where('trek_group', 'solo')
                    ->whereBetween('start_date', [$season['currentSeasonStartDate'], $season['currentSeasonEndDate']]),
                'private' => $query->where('trek_group', 'private')
                    ->whereBetween('start_date', [$season['currentSeasonStartDate'], $season['currentSeasonEndDate']]),
                'group' => $query->where('trek_group', 'group')
                    ->whereBetween('start_date', [$season['currentSeasonStartDate'], $season['currentSeasonEndDate']]),
                'trash' => $query->onlyTrashed(),
            };
        })

        ->when(! request('status'), function ($query) {
            return $query->whereNot(function ($query) {
                $query->where('end_date', '<', today());
                $query->orWhere('start_date', '<=', today())->where('end_date', '>=', today());
            });
        })

        ->select('user_packages.id', 'user_packages.user_id', 'user_packages.package_id', 'user_packages.number_of_trekkers', 'user_packages.trek_group', 'user_packages.start_date', 'user_packages.end_date', 'user_packages.airport_pickup', 'user_packages.total_amount', 'user_packages.payment_status', 'user_packages.created_at');

        return DataTables::eloquent($userPackages)

            ->editColumn('name', function ($userPackage) {
                $html = "<img title='".$userPackage->user->country->nicename."' src='".asset('flags/'.strtolower($userPackage->user->country->iso).'.png')."' /> {$userPackage->user->country->nicename} (x {$userPackage->number_of_trekkers})";

                $name = (request()->filled('status') && request('status') === 'trash')
                    ? $userPackage->user->name
                    : '<a href="'.route('admin.clients.package.show', $userPackage->id).'">'.$userPackage->user->name.'</a>';

                return $name.' <span class="text-primary" data-toggle="tooltip" data-placement="top" data-html="true" title="'.$html.'"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top"></i></span>';
            })

            ->editColumn('email', fn ($userPackage) => $userPackage->user->email)

            ->editColumn('package', function ($userPackage) {
                $html = $userPackage->package->name;

                $addons = '';

                if ($userPackage->addons->isNotEmpty()) {
                    foreach ($userPackage->addons as $addon) {
                        $addons .= "<span class='d-block text-primary font-weight-bold'>{$addon->name} x {$addon->count}</span>";
                    }

                    $html .= ' <span class="text-primary" data-toggle="tooltip" data-placement="top" data-html="true" title="'.$addons.'"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top"></i></span>';
                }

                return $html;
            })

            ->editColumn('trek_group', fn ($userPackage) => ucfirst($userPackage->trek_group))

            ->editColumn('start_date', fn ($userPackage) => $userPackage->start_date->format('D M j, Y'))

            ->editColumn('end_date', fn ($userPackage) => $userPackage->end_date->format('D M j, Y'))

            ->editColumn('airport_pickup', fn ($userPackage) => $userPackage->airport_pickup ?? 'No')

            ->editColumn('created_at', fn ($userPackage) => $userPackage->created_at->format('D M j, Y'))

            ->addColumn('status', function ($userPackage) {
                $filteredPayments = $userPackage->payments->filter(function ($item) {
                    return ! (str_contains($item->payment_type, 'refund'));
                });

                $totalPayment = $filteredPayments->sum('amount');

                if ($totalPayment >= $userPackage->total_amount) {
                    return '<span class="badge badge-success">Paid</span>';
                }

                return match ($userPackage->payment_status) {
                    'deposit' => '<span class="badge badge-primary">Deposit</span>',
                    'full' => '<span class="badge badge-success">Paid</span>',
                    default => '<span class="badge badge-warning">Pending</span>'
                };
            })

            ->addColumn('action', function ($userPackage) {
                $html = '';

                if (request()->filled('status') && request('status') == 'trash') {
                    if (auth()->user()->can('delete_clients')) {
                        $html .= ' <a title="'.__('Restore').'" class="btn btn-sm btn-success btn-delete" href="javascript:;" onclick="restore(\''.route('admin.clients.package.departure.restore').'\', \''.$userPackage->id.'\', \'clients\')"><i class="fas fa-trash-restore"></i></a>';

                        $html .= ' <a title="'.__('Permanently Delete').'" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDeletePermanently(\''.route('admin.clients.package.departure.delete_selected_permanently').'\', \''.$userPackage->id.'\', \'clients\')"><i class="far fa-trash-alt"></i></a>';
                    } else {
                        $html .= '<button class="btn btn-sm btn-danger btn-flat">'.__('No permission granted.').'</button>';
                    }
                } else {
                    if (auth()->user()->can('delete_clients')) {
                        $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\''.route('admin.clients.package.departure.delete', $userPackage).'\', \'clients\', \'Deleted items move into trash.\')"><i class="far fa-trash-alt"></i></a>';
                    } else {
                        $html .= '<button class="btn btn-sm btn-danger btn-flat">No permission granted.</button>';
                    }
                }

                return $html;
            })

            ->rawColumns(['name', 'package', 'status', 'action'])

            ->toJson();
    }
}
