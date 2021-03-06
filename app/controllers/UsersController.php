<?php

class UsersController extends \BaseController {

	public function home()
	{
        $devices = Device::join('users_devices','devices.id','=','users_devices.devices_id')->where('users_devices.users_id',Auth::user()->id)->get();
        $coordinates = [];
        foreach( $devices as $device){
            $dato = Data::where('devices_id',$device->id)->orderBy('id', 'DESC')->take(100)->get();
            if($dato) {
                foreach($dato as $data) {
                    $coordinates[$device->id][] = array($data['latitude'],$data['longitude']);
                }
            }

        }
        $statuses = Status::all();
        return View::make('users.home')->with(compact('devices','coordinates','statuses'));
	}
    public function create(){
        return View::make('app.users.new');
    }
    public function config(){
        return View::make('users.config');
    }

    public function profile(){
        $user = Auth::user();
        $devices = Device::join('users_devices','users_devices.devices_id','=','devices.id')->where('users_devices.users_id','=',Auth::user()->id)->get();
        return View::make('users.profile')->with(compact('user','devices'));
    }

}
