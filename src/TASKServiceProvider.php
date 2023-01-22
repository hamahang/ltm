<?php

namespace Hamahang\LTM;

use Request;
use Validator;
use Illuminate\Support\ServiceProvider;


class TASKServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    public function boot()
    {
        $this->loadRoutesFrom( __DIR__.'/Routes/backend_task_route.php');
        $this->loadRoutesFrom( __DIR__.'/Routes/client_task_route.php');


        $this->publishes([
            __DIR__ . '/Database/Migrations/' => database_path('migrations')
        ], 'migrations');

        $this->loadViewsFrom(__DIR__ . '/Views', 'laravel_task_manager');

        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/laravel_task_manager'),
        ]);

        $this->publishes([
            __DIR__.'/assets' => public_path('vendor/laravel_task_manager'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/Config/laravel_task_manager.php' => config_path('laravel_task_manager.php'),
            __DIR__ . '/Config/task_logs.php' => config_path('task_logs.php'),
            __DIR__ . '/Config/task_logs_data.php' => config_path('task_logs_data.php'),
            __DIR__ . '/Config/tasks.php' => config_path('tasks.php'),
        ],'config');

        $this->publishes([
            __DIR__.'/Lang' => resource_path('lang'),
        ], 'lang');

        $this->publishes([
            __DIR__.'/Traits' => app_path('Traits'),
        ], 'traits');

        //-------------------------------validation --------------------------------------------
        Validator::extend('jalali_date_if', function ($attribute, $value, $parameters, $validator)
        {
            $target_field = array_shift($parameters);
            $target_value = Request::get($target_field);
            if (in_array($target_value, $parameters))
            {
                // ------------------------------------------------------------------ //
                $value = ltm_ConvertNumbersFatoEn($value);
                $matches = [];
                if (!$parameters || empty($parameters))
                {
                    $parameters[0] = '\/';
                }
                elseif ($parameters[0] == '/')
                {
                    $parameters[0] = '\/';
                }
                preg_match('/^((?:13|14)\d\d)[' . $parameters[0] . '](0[1-9]|1[012])[' . $parameters[0] . '](0[1-9]|[12][0-9]|3[01])$/i', $value, $matches);
                return isset($matches[0]);
                // ------------------------------------------------------------------ //
            } else
            {
                return true;
            }
        });

        Validator::extend('check_captcha', function ($attribute, $value, $parameters, $validator) {
            return ltm_check_captcha($parameters[0], strtoupper($value));
        });

        Validator::extend('jalali_date', function ($attribute, $value, $parameters) {
            $value = ltm_ConvertNumbersFatoEn($value);
            $matches = [];
            if (!$parameters || empty($parameters))
            {
                $parameters[0] = '\/';
            }
            elseif ($parameters[0] == '/')
            {
                $parameters[0] = '\/';
            }
            preg_match('/^((?:13|14)\d\d)[' . $parameters[0] . '](0[1-9]|1[012])[' . $parameters[0] . '](0[1-9]|[12][0-9]|3[01])$/i', $value, $matches);
            return isset($matches[0]);
        });

        Validator::extend('jalali_date_after', function ($attribute, $value, $parameters) {
            $field = $attribute;
            $field_value = $value;
            $parameter = array_shift($parameters);
            $parameter_values = $parameters;
            $compare_value = time();
            switch ($parameter)
            {
                case 'today':
                    {
                        $compare_value = ltm_Date_GtoJ(date('Y-m-d'), 'Y/m/d', false);
                        break;
                    }
                case 'yesterday':
                    {
                        $compare_value = ltm_Date_GtoJ(date('Y-m-d', strtotime("-1 days")), 'Y/m/d', false);
                        break;
                    }
                case 'field':
                    {
                        if (isset($parameter_values[0]))
                        {
                            $compare_value = Request::get($parameter_values[0]);
                        }
                        else
                        {
                            return false;
                        }
                    }
            }
            return $field_value > $compare_value;
        });

        Validator::extend('jalali_date_after_or_equal', function ($attribute, $value, $parameters) {
            $field = $attribute;
            $field_value = $value;
            $parameter = array_shift($parameters);
            $parameter_values = $parameters;
            $compare_value = time();
            switch ($parameter)
            {
                case 'today':
                    {
                        $compare_value = ltm_Date_GtoJ(date('Y-m-d'), 'Y/m/d', false);
                        break;
                    }
                case 'yesterday':
                    {
                        $compare_value = ltm_Date_GtoJ(date('Y-m-d', strtotime("-1 days")), 'Y/m/d', false);
                        break;
                    }
                case 'field':
                    {
                        if (isset($parameter_values[0]))
                        {
                            $compare_value = Request::get($parameter_values[0]);
                        }
                        else
                        {
                            return false;
                        }
                    }
            }
            return $field_value >= $compare_value;
        });

        Validator::extend('melli_code', function ($attribute, $value, $parameters) {
            if (!preg_match('/^\d{8,10}$/', $value) || preg_match('/^[0]{10}|[1]{10}|[2]{10}|[3]{10}|[4]{10}|[5]{10}|[6]{10}|[7]{10}|[8]{10}|[9]{10}$/', $value))
            {
                return false;
            }

            $sub = 0;

            if (strlen($value) == 8)
            {
                $value = '00' . $value;
            }
            elseif (strlen($value) == 9)
            {
                $value = '0' . $value;
            }

            for ($i = 0; $i <= 8; $i++)
            {
                $sub = $sub + ($value[$i] * (10 - $i));
            }

            if (($sub % 11) < 2)
            {
                $control = ($sub % 11);
            }
            else
            {
                $control = 11 - ($sub % 11);
            }

            if ($value[9] == $control)
            {
                return true;
            }
            else
            {
                return false;
            }
        });

        Validator::extend('iran_phone', function ($attribute, $value, $parameters) {
            $iran_phone = (bool)preg_match('/^[2-9][0-9]{7}+$/', $value);
            return $iran_phone;
        });

        Validator::extend('iran_mobile_phone', function ($attribute, $value, $parameters) {
            if ((bool)preg_match('/^(((98)|(\+98)|(0098)|0)(9){1}[0-9]{9})+$/', $value) || (bool)preg_match('/^(9){1}[0-9]{9}+$/', $value))
            {
                return true;
            }

            return false;
        });

        Validator::extend('postal_code', function ($attribute, $value, $parameters) {
            return (bool)preg_match("/^(\d{5}-?\d{5})$/", $value);
        });

        Validator::extend('persian_alpha', function ($attribute, $value, $parameters) {
            $value = str_replace(' ', '', $value);
            $value = str_replace('&zwnj;', '', $value);
            $persian_alpha = (bool)preg_match("/^[\x{600}-\x{6FF}\x{200c}\x{064b}\x{064d}\x{064c}\x{064e}\x{064f}\x{0650}\x{0651}\s]+$/u", $value);
            return $persian_alpha;
        });

        Validator::extend('english_alpha', function ($attribute, $value, $parameters) {
            $persian_alpha = (bool)preg_match("/^[a-zA-Z]+$/u", $value);
            return $persian_alpha;
        });

        Validator::extend('persian_num', function ($attribute, $value, $parameters) {
            $persian_num = (bool)preg_match('/^[\x{6F0}-\x{6F9}]+$/u', $value);
            return $persian_num;
        });

        Validator::extend('persian_alpha_num', function ($attribute, $value, $parameters) {
            $persian_alpha_num = (bool)preg_match('/^[\x{600}-\x{6FF}\x{200c}\x{064b}\x{064d}\x{064c}\x{064e}\x{064f}\x{0650}\x{0651}\s]+$/u', $value);
            return $persian_alpha_num;
        });

        Validator::extend('is_not_persian', function ($attribute, $value, $parameters) {
            if (is_string($value))
            {
                $is_not_persian = (bool)preg_match("/[\x{600}-\x{6FF}]/u", $value);
                return !$is_not_persian;
            }
            return false;
        });

        Validator::extend('sheba_code', function ($attribute, $value, $parameters) {
            $ibanReplaceValues = array();
            if (!empty($value))
            {
                $value = preg_replace('/[\W_]+/', '', strtoupper($value));

                if ((4 > strlen($value) || strlen($value) > 34) || (is_numeric($value [0]) || is_numeric($value [1])) || (!is_numeric($value [2]) || !is_numeric($value [3])))
                {
                    return false;
                }
                $ibanReplaceChars = range('A', 'Z');
                foreach (range(10, 35) as $tempvalue)
                {
                    $ibanReplaceValues[] = strval($tempvalue);
                }
                $tmpIBAN = substr($value, 4) . substr($value, 0, 4);
                $tmpIBAN = str_replace($ibanReplaceChars, $ibanReplaceValues, $tmpIBAN);
                $tmpValue = intval(substr($tmpIBAN, 0, 1));
                for ($i = 1; $i < strlen($tmpIBAN); $i++)
                {
                    $tmpValue *= 10;
                    $tmpValue += intval(substr($tmpIBAN, $i, 1));
                    $tmpValue %= 97;
                }
                if ($tmpValue != 1)
                {
                    return false;
                }
                return true;
            }
            return false;
        });

        Validator::extend('limited_array', function ($attribute, $value, $parameters) {
            //'limited_array:2'
            // Validate your array variable and must be contain 2 member or lesser
            if (is_array($value))
            {
                if (isset($parameters[0]))
                {
                    return ((count($value) <= $parameters[0]) ? true : false);
                }
                else
                {
                    return true;
                }
            }
            return false;
        });

        Validator::extend('unsigned_num', function ($attribute, $value, $parameters) {
            $unsigned_num = (bool)preg_match('/^\d+$/', $value);
            return $unsigned_num;
        });

        Validator::extend('card_number', function ($attribute, $value, $parameters) {
            if (!preg_match('/^\d{16}$/', $value))
            {
                return false;
            }
            $sum = 0;
            for ($position = 1; $position <= 16; $position++)
            {
                $temp = $value[$position - 1];
                $temp = $position % 2 === 0 ? $temp : $temp * 2;
                $temp = $temp > 9 ? $temp - 9 : $temp;

                $sum += $temp;
            }
            return (bool)($sum % 10 === 0);
        });

        Validator::extend('old_password', function ($attribute, $value, $parameters) {
            if (Hash::check($value, auth()->user()->password))
            {
                return true;
            }
            return false;
        });

        Validator::extend('max_attachment', function ($attribute, $value, $parameters) {
            $process_file = SysProcessFiles::find($parameters[0]);
            $attachments = SysRequest::find($parameters[1])->attachments->first(function ($v, $k) use ($process_file) {
                return $v->id == $process_file->id;
            })->files->count();
            if ($process_file->max_file_number > $attachments)
            {
                return true;
            }
            return false;
        });

        Validator::extend('lower_then_filed', function ($attribute, $value, $parameters, $validator) {
            $min_field = $parameters[0];
            $data = $validator->getData();
            $min_value = $data[$min_field];
            return $value <= $min_value;
        });

        Validator::extend('check_type_meessage', function ($attribute, $value, $parameters, $validator) {
            $arr_message = ['error', 'info', 'warning'];
            if (in_array($value, $arr_message))
            {
                return true;
            }
            else
            {
                return false;
            }
        });


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    	// set the main config file
	    $this->mergeConfigFrom(
		    __DIR__ . '/Config/laravel_task_manager.php', 'laravel_task_manager'
	    );

		// bind the FAQ Facade
	    $this->app->bind('TASK', function () {
		    return new TASK;
	    });
    }
}
