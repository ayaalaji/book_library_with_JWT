<?php

namespace App\Traits;

trait apiResponseTrait{
    public function responseApi($data,$message,$status)
    {
        $array=[
            $data,
            $message,
        ];
        return response()->json($array , $status);
    }
}