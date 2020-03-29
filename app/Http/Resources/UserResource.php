<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Role;
use App\User;

class UserResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        /*return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString()
            //'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString()
        ];*/
        $itemList = [];

        foreach ($this->collection as $item) {

            array_push($itemList, [
                'id' => $item->id,
                'name' => $item->name,
                'email' => $item->email,
                'role' => User::where('id', $item->id)->with('roles')->first()->roles()->first()->name,
                'role_id' => User::where('id', $item->id)->with('roles')->first()->roles()->first()->id,
                'created_at'=>Carbon::parse($item->created_at)->toDateTimeString()
            ]);
        }
        return $itemList;
        
    }
}
