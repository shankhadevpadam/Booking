<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserDataTable
{
    public function __invoke()
    {
        $users = User::with('roles')
            ->where('is_admin', true)
            ->when(request()->filled('status') && request('status') == 'trash', function ($query) {
                $query->onlyTrashed();
            })->select('users.*');

        return DataTables::eloquent($users)
            ->addColumn('role', function ($user) {
                return $user->roles->first()->name;
            })

            ->addColumn('action', function ($user) {
                $html = '';

                if (!$user->hasRole('Super Admin')) {
                    if (request()->filled('status') && request('status') === 'trash') {
                        if (auth()->user()->can('delete_users')) {
                            $html .= ' <a title="' . __('Restore') . '" class="btn btn-sm btn-success btn-delete" href="javascript:;" onclick="restore(\'' . route('admin.users.restore') . '\', \'' . $user->id . '\', \'users\')"><i class="fas fa-trash-restore"></i></a>';

                            $html .= ' <a title="' . __('Permanently Delete') . '" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDeletePermanently(\'' . route('admin.users.delete_selected_permanently') . '\', \'' . $user->id . '\', \'users\')"><i class="far fa-trash-alt"></i></a>';
                        } else {
                            $html .= '<button class="btn btn-sm btn-danger btn-flat">' . __('No permission granted.') . '</button>';
                        }
                    } else {
                        if (auth()->user()->can('edit_users')) {
                            if ($user->roles->first()->name === 'Guide' && !$user->approved_at) {
                                $html .= '<span class="btn btn-sm btn-primary mr-1" onclick="approve(' . $user->id . ')">Approve</span>';
                            }

                            $html .= '<a title="Edit" class="btn btn-sm btn-success" href="' . route('admin.users.edit', $user) . '"><i class="far fa-edit"></i></a>';
                        }

                        if (auth()->user()->can('delete_users')) {
                            $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\'' . route('admin.users.delete', $user) . '\', \'users\', \'Deleted items move into trash.\')"><i class="far fa-trash-alt"></i></a>';
                        } else {
                            $html .= '<button class="btn btn-sm btn-danger btn-flat">No permission granted.</button>';
                        }
                    }

                    return $html;
                }
            })

            ->rawColumns(['action'])

            ->toJson();
    }
}
