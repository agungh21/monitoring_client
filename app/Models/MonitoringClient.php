<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringClient extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function getStatus(){
        if($this->status == 'Aktif'){
            return 'Aktif';
        }

        if($this->status == 'Tidak Aktif'){
            return 'Tidak Aktif';
        }
    }

    public function getStatusHtml(){
        if($this->status == 'Aktif'){
            return '<span class="badge badge-success">Aktif</span>';
        }

        if($this->status == 'Tidak Aktif'){
            return '<span class="badge badge-danger">Tidak Aktif</span>';
        }
    }

    public static function createMonitoringClient(array $request){
        $monitoringClient = new self();
        $monitoringClient->status = $request['status'];
        $monitoringClient->tanggal = $request['tanggal'];
        $monitoringClient->user = $request['user'];
        $monitoringClient->ip_client = $request['ip_client'];
        $monitoringClient->caller_id = $request['caller_id'];
        $monitoringClient->uptime = $request['uptime'];
        $monitoringClient->total_active = $request['total_active'];
        $monitoringClient->service = $request['service'];
        $monitoringClient->last_disconnect_reason = $request['last_disconnect_reason'];
        $monitoringClient->last_logout = $request['last_logout'];
        $monitoringClient->last_caller_id = $request['last_caller_id'];
        $monitoringClient->save();
        return $monitoringClient;
    }
    public static function dt($request)
    {
        $data = self::where('created_at', '!=', NULL);

        if($request->status != "all"){
            $data = $data->where('status', $request->status);
        }

        $data->orderBy('created_at', 'desc');

        return \Datatables::eloquent($data)
            ->editColumn('status', function ($data) {
                return $data->getStatusHtml();
            })
            ->rawColumns(['status'])
            ->make(true);
    }
}
