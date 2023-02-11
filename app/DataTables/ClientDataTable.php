<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class ClientDataTable
{
    public function __invoke()
    {
        $users = User::role('Client')
            ->when(request()->filled('status') && request('status') == 'trash', function ($query) {
                $query->onlyTrashed();
            });

        return DataTables::eloquent($users)
            ->addColumn('action', function ($user) {
                $html = '';

                if (request()->filled('status') && request('status') === 'trash') {
                    if (auth()->user()->can('delete_clients')) {
                        $html .= ' <a title="'.__('Restore').'" class="btn btn-sm btn-success btn-delete" href="javascript:;" onclick="restore(\''.route('admin.clients.restore').'\', \''.$user->id.'\', \'clients\')"><i class="fas fa-trash-restore"></i></a>';

                        $html .= ' <a title="'.__('Permanently Delete').'" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDeletePermanently(\''.route('admin.clients.delete_selected_permanently').'\', \''.$user->id.'\', \'clients\')"><i class="far fa-trash-alt"></i></a>';
                    } else {
                        $html .= '<button class="btn btn-sm btn-danger btn-flat">'.__('No permission granted.').'</button>';
                    }
                } else {
                    if (auth()->user()->can('edit_clients')) {
                        $html .= '<a title="Edit" class="btn btn-sm btn-success" href="'.route('admin.clients.edit', $user).'"><i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('delete_clients')) {
                        $html .= ' <a title="Delete" class="btn btn-sm btn-danger btn-delete" href="javascript:;" onclick="confirmDelete(\''.route('admin.clients.delete', $user).'\', \'clients\', \'Deleted items move into trash.\')"><i class="far fa-trash-alt"></i></a>';
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
