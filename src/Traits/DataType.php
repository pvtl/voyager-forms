<?php

namespace Pvtl\VoyagerForms\Traits;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

trait DataType
{
    public function getDataType(Request $request)
    {
        return Voyager::model('DataType')
            ->where('slug', '=', $this->getSlug($request))
            ->first();
    }
}
