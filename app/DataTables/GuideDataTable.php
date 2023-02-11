<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class GuideDataTable
{
    public function __invoke()
    {
        $guides = User::role('Guide')
            ->latest('id')
            ->when(request()->filled('status') && request('status') == 'trash', function ($query) {
                $query->onlyTrashed();
            });

        return DataTables::eloquent($guides)
            ->addColumn('action', function ($user) {
                $html = '';

                if (request()->filled('status') && request('status') === 'trash') {
                    if (auth()->user()->can('delete_guides')) {
                        $html .= ' <a title="'.__('Restore').'" class="btn btn-sm btn-success btn-delete" href="javascript:;" onclick="restore(\''.route('admin.guides.restore').'\', \''.$user->id.'\', \'guides\')"><i class="fas fa-trash-restore"></i></a>';

                        $html .= ' <a title="'.__('Permanently Delete').'" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDeletePermanently(\''.route('admin.guides.delete_selected_permanently').'\', \''.$user->id.'\', \'guides\')"><i class="far fa-trash-alt"></i></a>';
                    } else {
                        $html .= '<button class="btn btn-sm btn-danger btn-flat">'.__('No permission granted.').'</button>';
                    }
                } else {
                    if (auth()->user()->can('edit_guides')) {
                        if (! $user->approved_at) {
                            $html .= '<span class="btn btn-sm btn-primary mr-1" onclick="approve('.$user->id.')">Approve</span>';
                        }

                        $html .= '<a title="Edit" class="btn btn-sm btn-success" href="'.route('admin.guides.edit', $user).'"><i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('delete_guides')) {
                        $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\''.route('admin.guides.delete', $user).'\', \'guides\', \'Deleted items move into trash.\')"><i class="far fa-trash-alt"></i></a>';
                    } else {
                        $html .= '<button class="btn btn-sm btn-danger btn-flat">No permission granted.</button>';
                    }
                }

                return $html;
            })

            ->rawColumns(['action'])

            ->toJson();
    }
}
