<?php

namespace Pvtl\VoyagerForms\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormValidators
{
    public static function validateHook(Request $request): \Illuminate\Validation\Validator
    {
        $controllerMethodPath = $request->input('hook');
        $validator = Validator::make($request->all(), []);

        return $validator->after(function ($validator) use ($controllerMethodPath) {
            if (strpos($controllerMethodPath, '::') === false) {
                $validator->errors()->add('path', 'You must call your method statically using the "::" separator');

                return $validator;
            }

            list($controller, $method) = explode('::', $controllerMethodPath);
            preg_match('/\(.*?\)/', $controllerMethodPath, $parameters);

            if (count($parameters) > 0) {
                $method = str_replace($parameters[0], '', $method);
            }

            if (empty($method)) {
                $validator->errors()->add('path', "You must define a method on your included controller");
            }

            if (!class_exists($controller)) {
                $validator->errors()->add('path', "Could not locate class $controller");
            }

            if (!method_exists($controller, $method)) {
                $validator->errors()->add('path', "Could not locate method $method in $controller");
            }

            return $validator;
        });
    }
}
