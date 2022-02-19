<?php

/**
 * Predefined Messages
 */
define('SUCCESS', 'Successfully created');
define('FAIL', 'Failed to create');
define('UPDATE_SUCCESS', 'Successfully updated');
define('UPDATE_FAIL', 'Failed to update');
define('SERVER_ERROR', 'Internal server error!');
define('DELETE_SUCCESS', 'Successfully deleted');
define('DELETE_FAIL', 'Failed to delete');
define('UNAUTHORIZED', 'These credentials do not match our records.');
define('PERMISSION_DENIED', 'Insufficient Permissions!');
define('PAGINATE_LIMIT', 25);

/**
 * Flash message with label
 * @Param String $message
 * @param String $level ='info'
 * @Return null
 */
if (!function_exists('flash')) {
    function flash($message, $level = 'success', $important = false)
    {
        session()->flash('flash_message', $message);
        session()->flash('flash_message_level', $level);
        session()->flash('flash_important', $important);
    }
}

/**
 * Remove spaces from string
 */
if (!function_exists('removeSpace')) {
    function removeSpace($str)
    {
        return preg_replace('/\s+/', '', $str);
    }
}

/**
 * Common json response with datas
 */
if (!function_exists('respond')) {
    function respond($data, $key = 'data', $code = 200, $status = true)
    {
        return response()->json([
            'success' => $status,
            "{$key}" => $data,
        ], $code);
    }
}

/**
 * Common json success response
 */
if (!function_exists('respondSuccess')) {
    function respondSuccess($message, $code = 200, $status = true)
    {
        return response()->json([
            'success' => $status,
            'message' => $message
        ], $code);
    }
}

/**
 * Common json error response
 */
if (!function_exists('respondError')) {
    function respondError($message, $code = 500, $status = false)
    {
        return response()->json([
            'success' => $status,
            'message' => $message
        ], $code);
    }
}

/**
 * Generate Menu Urls
 */
if (!function_exists('generateNavUrl')) {
    function generateNavUrl($route, $url, $hasSubNav = null)
    {
        if ($hasSubNav) {
            return 'javascript:';
        }

        $url = removeSpace($url);
        $route = removeSpace($route);

        if (($url == 'null' || empty($url) || !$url) && ($route == 'null' || empty($route) || !$route)) {
            return 'javascript:';
        }
        return ($url == 'null' || empty($url) || !$url) ? route($route) : url($url);
    }
}

/**
 * get active organisation id
 */
if (!function_exists('getOrgId')) {
    function getOrgId()
    {
        return session('activeOrganisation')->id ?? null;
    }
}

/**
 * Date Format
 */
if (!function_exists('dateFormat')) {
    function dateFormat($date, $format = 'l, d F Y')
    {
        if(empty($date)) {
            return '';
        }
        
        return date($format, strtotime($date));
    }
}

/**
 * get admin email
 */
if (!function_exists('getAdminEmail')) {
    function getAdminEmail()
    {
        return \App\Models\User::where('role', 'admin')->select('email')->first()->email ?? 'trainingattendance@melinsight.com';
    }
}

/**
 * get super admin email
 */
if (!function_exists('sendToSuperAdminMail')) {
    function sendToSuperAdminMail()
    {
        return 'trainingattendance@melinsight.com';
    }
}

/**
 * get cc emails
 */
if (!function_exists('ccEmails')) {
    function ccEmails()
    {
        $ccEmails = [];
        $user = auth()->user();
        if($user->isTrainer()) {
            if($supervisor = $user->parent) {
                if($approver = $supervisor->parent) {
                    $ccEmails[] = $approver->email;
                }
                $ccEmails[] = $supervisor->email;
            }
        } else {
            if($observer = $user->parent) {
                $ccEmails[] = $observer->email;
            }
        }

        return $ccEmails;
    }
}

/**
 * event report send to emails
 */
if (!function_exists('sendToEmailForReport')) {
    function sendToEmailForReport()
    {
        $toMail = null;
        $user = auth()->user();
        if($user->isTrainer()) {
            if($supervisor = $user->parent) {
                $toMail = $supervisor->email;
            }
        } else if($user->isSupervisor()) {            
            if($approver = $user->parent) {
                $toMail = $approver->email;
            }
        }
        
        return $toMail;
    }
}



/**
 * Division lists
 */
if (!function_exists('getDivision')) {
    function getDivision()
    {
        return ['BARISAL', 'CHITTAGONG', 'DHAKA', 'KHULNA'];
    }
}

/**
 * get participant table headers lists
 */
if (!function_exists('getParticipantHeader')) {
    function getParticipantHeader($event)
    {
        if(empty($event)) {
            return 'Picture, Type, Group, Participant ID, Names, Personal, Mobile, Address,  Status, Remarks';
        }

        return 'Picture, Type, Group, Participant ID, Names, Personal, Mobile, Attendance';
    }
}

if (!function_exists('random_color')) {
    function random_color() {
        $rgbColor = [];
        
        //Create a loop.
        foreach(['r', 'g', 'b'] as $color){
            //Generate a random number between 0 and 255.
            $rgbColor[$color] = mt_rand(0, 255);
        }
        return implode(',', $rgbColor);
    }
}

