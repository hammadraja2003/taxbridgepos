<?php

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

if (!function_exists('normalize_to_sql_datetime')) {
    function normalize_to_sql_datetime($input, $useCurrentTime = false)
    {
        if (empty($input)) {
            return Carbon::now()->format('Y-m-d H:i:s');
        }

        $input = trim($input);

        // Replace multiple possible separators with "-"
        $normalized = preg_replace('/[\/\.\s]+/', '-', $input);

        // Formats to test (you can add more if needed)
        $formats = [
            'd-m-Y',
            'd/m/Y',
            'd.m.Y',
            'm-d-Y',
            'm/d/Y',
            'm.d.Y',
            'Y-m-d',
            'Y/m/d',
            'Y.m.d',
        ];

        foreach ($formats as $fmt) {
            try {
                $date = Carbon::createFromFormat($fmt, $normalized);

                if ($date !== false) {
                    if ($useCurrentTime) {
                        // inject current time if only date provided
                        $date->setTimeFrom(Carbon::now());
                    }
                    return $date->format('Y-m-d H:i:s');
                }
            } catch (\Exception $e) {
                // just continue to next format
            }
        }

        // fallback: try Carbon::parse (loose parsing)
        try {
            $date = Carbon::parse($input);
            if ($useCurrentTime) {
                $date->setTimeFrom(Carbon::now());
            }
            return $date->format('Y-m-d').' '.date('H:i:s');
        } catch (\Exception $e) {
            // totally failed → return current datetime
            return Carbon::now()->format('Y-m-d H:i:s');
        }
    }
}
if (!function_exists('getTenantUnreadNotificationsByDate')) {
 function getTenantUnreadNotificationsByDate($date, $user = null)
    {
        $user = $user ?? Auth::user();
        
        if (!$user) {
            return 0;
        }

        return DB::connection('tenant')
            ->table('notifications')
            ->where('notifiable_id', $user->id)
            ->where('notifiable_type', 'App\\Models\\User')
            ->whereNull('read_at')
            ->where('data->reminder_date', $date)
            ->count();
    }
}
if (!function_exists('getGeneralSetting')) {
    function getGeneralSetting()
    {
        $bus_config_id = session()->get('bus_config_id');
        $key_prefix = 'tenant_' . $bus_config_id . '_';
        $general_setting = cache()->get($key_prefix . 'general_setting');
        
        if (!$general_setting) {
            // Fallback to master connection
            $general_setting = DB::connection('master')
                ->table('general_settings')
                ->where('bus_config_id', $bus_config_id)
                ->latest()
                ->first();
        }
        
        return $general_setting;
    }
}
if (!function_exists('getConnectionName')) {
    function getConnectionName($model)
    {
        if (is_string($model)) {
            $model = app($model);
        }
        if (! $model instanceof Model) {
            throw new InvalidArgumentException('Invalid model provided');
        }

        return $model->getConnectionName()
            ?? config('database.default');
    }
}
if (!function_exists('getProductTypeDropdown')) {

    function getProductTypeDropdown(
        $name,
        $class = 'form-control selectpicker',
        $id = '',
        $required = false,
        $selectedValue = null
    ) {
        $typeValues = ['standard', 'combo', 'digital', 'service'];

        $requiredAttr = $required ? 'required' : '';
        $idAttr = $id ? "id=\"{$id}\"" : '';

        $html = "<select name=\"{$name}\" class=\"{$class}\" {$idAttr} {$requiredAttr}>";

        foreach ($typeValues as $value) {
            $selected = ($value === strtolower($selectedValue)) ? 'selected' : '';
            $label = ucfirst($value);

            $html .= "<option value=\"{$value}\" {$selected}>{$label}</option>";
        }

        $html .= "</select>";

        return $html;
    }
}
if (!function_exists('getRoleTypeDropdown')) {

    function getRoleTypeDropdown(
        $name,
        $class = 'form-control selectpicker',
        $id = '',
        $required = false,
        $selectedValue = null
    ) {
        $types = [
            1 => 'admin',
            2 => 'owner',
            3 => 'staff',
            4 => 'customer'
        ];

        $requiredAttr = $required ? 'required' : '';
        $idAttr = $id ? "id=\"{$id}\"" : '';

        $html = "<select name=\"{$name}\" class=\"{$class}\" {$idAttr} {$requiredAttr}>";

        foreach ($types as $key => $value) {
            $selected = ((string)$key === (string)trim($selectedValue)) ? 'selected' : '';
            $label = ucfirst($value);

            $html .= "<option value=\"{$key}\" {$selected}>{$label}</option>";
        }

        $html .= "</select>";

        return $html;
    }
}
if (!function_exists('getRoleType')) {

    function getRoleType(
        $role_type
    ) {
        $types = [
            1 => 'admin',
            2 => 'owner',
            3 => 'staff',
            4 => 'customer'

        ];

        return $types[$role_type];
    }
}
