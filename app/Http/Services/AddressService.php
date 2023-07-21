<?php

namespace App\Http\Services;

use App\Models\Address;
use App\Models\DiaChi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class  AddressService
{
    public function destroy($request)
    {
        $address = DiaChi::where('id', $request->input('id'))->first();
        if ($address) {
            $address->delete();
            return true;
        }

        return false;
    }
}
