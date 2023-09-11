<?php
function generate_validation($_post)
{
    $html = '';

    foreach ($_post as $key => $post) {
        if ($key != 'tbl_id') {
            $html .= '$this->form_validation->set_rules("' . $key . '", "' . $key . '", "trim|required");';
        }
    }
    return $html;
}

function posted_fields($_post)
{
    $ci_this = &get_instance();
    $info    = array();
    foreach ($_post as $key => $post) {
        $info[$key] = clean_posted_value($ci_this->input->post($key));
    }

    return $info;
}

function clean_posted_value($value)
{
    return trim($value);
}

function last_query()
{
    $ci_this = &get_instance();
    echo $ci_this->db->last_query();
    exit;
}

function pre_print($data)
{
    echo '<pre>';
    print_r($data);
    exit;
}

function encode($value)
{
    return base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($value)))))));
}

function decode($value)
{
    return base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($value)))))));
}

function send_email_codeigniter($content, $subject, $to_email, $to_name, $from_name = SUPPORT_SITE, $from_email = SMTP_USER, $attachments = array())
{
    error_reporting(0);
    $ci_this = &get_instance();
    $ci_this->load->library(array('email', 'session'));
    $ci_this->email->clear();
    $config['protocol']    = "mail";
    $config['smtp_host']   = SMTP;
    $config['smtp_port']   = SMTP_PORT;
    $config['smtp_user']   = SMTP_USER;
    $config['smtp_pass']   = SMTP_PASSWORD;
    $config['smtp_crypto'] = 'tls';
    $config['charset']     = "utf-8";
    $config['mailtype']    = "html";
    $config['newline']     = "\r\n";
    $config['starttls']    = TRUE;
    $ci_this->email->initialize($config);
    $ci_this->email->from($from_email, $from_name);
    $ci_this->email->to($to_email);
    $ci_this->email->subject($subject);
    $ci_this->email->message($content);

    if (!empty($attachments)) {
        foreach ($attachments as $attachment) {
            $this->email->attach($attachment['file_url'], 'attachment', $attachment['filename']);
        }
    }

    if ($ci_this->email->send()) {
        //print_r( $ci_this->email->print_debugger());
        return TRUE;
    } else {
        //print_r( $ci_this->email->print_debugger());
        return FALSE;
    }
}

function sendgrid_api($html, $subject, $sendTo, $to_name, $from_name = SUPPORT_SITE, $from_email = SUPPORT_EMAIL, $attachments = array())
{
    $url                        = 'https://api.sendgrid.com/';
    $json_string['to'][0]       = $sendTo;
    $json_string['category'][0] = 'API';
    //echo '<pre>';print_r(json_encode ( $json_string ));exit;
    $params = array(
        //'api_user'  => 'Ahmed.niazi8',
        //'api_key'   => 'H@seebahsan13',
        'x-smtpapi' => json_encode($json_string),
        'to' => $from_email,
        'subject' => $subject,
        'html' => $html,
        'from' => $from_email,
        'fromname' => $from_name
    );

    if (!empty($attachments)) {
        foreach ($attachments as $attachment) {
            $params['files[' . str_replace(' ', '-', $attachment['filename']) . ']'] = '@' . $attachment['file_url'];
            //$this->email->attach($attachment->file_url, 'attachment', $attachment0>filename);
            //https://sendgrid.com/docs/for-developers/sending-email/v2-php-code-example/
        }
    }

    $request = $url . 'api/mail.send.json';
    // Generate curl request
    $ch = curl_init($request);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer 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'));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer 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'));
    // Tell curl to use HTTP POST
    curl_setopt($ch, CURLOPT_POST, TRUE);
    // Tell curl that this is the body of the POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    // Tell curl not to return headers, but do return the response
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    // Tell PHP not to use SSLv3 (instead opting for TLS)
    //curl_setopt ( $ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2 );

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $json_response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($json_response);
    //pre_print($response);
    return TRUE;//!empty($response->msg) ? true : false;
}

function send_email($html, $subject, $sendTo, $to_name, $from_name = SUPPORT_SITE, $from_email = SUPPORT_EMAIL, $attachments = array())
{
    require(ABSOLUTE_PATH . "sendgrid-php/sendgrid-php.php");
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom($from_email, $from_name);
    $email->setSubject($subject);
    $email->addTo($sendTo, $to_name);
    $email->addContent("text/html", $html);
    if (!empty($attachments)) {
        foreach ($attachments as $attachment) {
            //$params['files['.str_replace(' ','-',$attachment['filename']).']'] = '@'.$attachment['file_url'];
            $file_encoded = base64_encode(file_get_contents($attachment['file_url']));
            $email->addAttachment(
                $file_encoded,
                "application/text", //application/pdf
                str_replace(' ', '-', $attachment['filename']),
                "attachment"
            );
            //$email->addAttachment($attachment['file_url']);
        }
    }
    $sendgrid = new \SendGrid('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');
    try {
        $response = $sendgrid->send($email);
        //print $response->statusCode() . "\n";
        //print_r($response->headers());
        //print $response->body() . "\n";
        return TRUE;
    } catch (Exception $e) {
        //echo 'Caught exception: '. $e->getMessage() ."\n";
        return FALSE;
    }
}

function profile_img_url($user_id, $value)
{
    if ($value == '') {
        return ADMIN_ASSETS . 'img/avatar.png';
    } else if (file_exists(USR_PHOTOS . $user_id . '/' . $value)) {
        return USR_PHOTOS_URL . $user_id . '/' . $value;
    } else {
        return ADMIN_ASSETS . 'img/avatar.png';
    }
}

function attachment_url($order_reference, $filename)
{
    if ($filename == '') {
        return 0;
    }

    return UPLOADS_URL . strtolower($order_reference) . '/' . $filename;
}

function attachment_dir($order_id, $filename)
{
    if ($filename == '') {
        return 0;
    }

    return UPLOADS . $order_id . '/' . $filename;
}

function monthyear($date)
{
    return date('M, Y', strtotime($date));
}

function dmy($date)
{
    return date('d, M Y', strtotime($date));
}

function dmytime($date)
{
    return date('d, M Y, h:i A', strtotime($date));
}

function dmyhm($date)
{
    return dmytime($date);
}

function hoursmin($date)
{
    return date('h:i A', strtotime($date));
}

function format_datetime()
{
    $date = new DateTime('now', new DateTimeZone('Asia/Karachi'));
    return $date->format('Y-m-d H:i:s');
}

function format_time()
{
    $date = new DateTime('now', new DateTimeZone('Asia/Karachi'));
    return $date->format('H:i:s');
}

function pagination_func($base_url, $total_rows, $uri_segment)
{
    $ci_this = &get_instance();
    $ci_this->load->library('pagination');
    $config['base_url']    = $base_url;
    $config['total_rows']  = $total_rows;
    $config['uri_segment'] = $uri_segment;
    $config['per_page']    = PER_PAGE;
    $ci_this->pagination->initialize($config);
    return $ci_this->pagination->create_links();
}

function select_tpl($records, $field_name, $field_title, $required = 'y', $selected = '')
{
    $blur = $required == 'y' ? ' onBlur="validate(\'dd\', \'dd\', \'' . $field_name . '\', \'' . $field_title . '\');"' : '';
    $html = '';
    $html = '<select id="' . $field_name . '" name="' . $field_name . '" class="form-control mb-1"' . $blur . '>';
    $html .= '<option value="">Select ' . $field_title . '</option>';
    foreach ($records as $record) {
        $selected_opt = '';
        if ($selected != '' && $selected == $record->id) {
            $selected_opt = ' selected';
        }
        $html .= '<option value="' . $record->id . '"' . $selected_opt . '>' . $record->title . '</option>';
    }
    $html .= '</select>';
    return $html;
}

function multi_select_tpl($records, $field_name, $field_title, $required = 'y', $selected = '')
{
    $blur     = $required == 'y' ? ' onBlur="validate(\'dd\', \'dd\', \'' . $field_name . '\', \'' . $field_title . '\');"' : '';
    $html     = '';
    $html     = '<select id="' . $field_name . '" name="' . $field_name . '[]" multiple class="form-control multiple mb-1"' . $blur . '>';
    $html     .= '<option value="">Select ' . $field_title . '</option>';
    $selected = explode(',', $selected);
    foreach ($records as $record) {
        $selected_opt = '';
        if (!empty($selected) && in_array($record->id, $selected)) {
            $selected_opt = ' selected';
        }
        $html .= '<option value="' . $record->id . '"' . $selected_opt . '>' . $record->title . '</option>';
    }
    $html .= '</select>';
    return $html;
}

function row_status($val = 1)
{
    if ($val == 1) {
        return '<badge class="badge badge-success">Active</badge>';
    } else if ($val == 0) {
        return '<badge class="badge badge-danger">Inactive</badge>';
    }


}

function row_standard($val = 1)
{
    if ($val == 1) {
        return '<badge class="badge badge-primary">Standard</badge>';
    } else if ($val == 0) {
        return '<badge class="badge badge-success">Premium</badge>';
    }


}

function row_yes($val = 1)
{
    if ($val == '1') {
        return '<badge class="badge badge-success">Yes</badge>';
    } else if ($val == '0') {
        return '<badge class="badge badge-primary">No</badge>';
    }


}

function row_personalized($val = 1)
{
    if ($val == '1') {
        return '<badge class="badge badge-success">Yes</badge>';
    } else if ($val == '2') {
        return '<badge class="badge badge-primary">No</badge>';
    }


}

function row_paid_by($val = 'stripe')
{
    if ($val == 'stripe') {
        return '<badge class="badge badge-success">Stripe</badge>';
    } else if ($val == 'paypal') {
        return '<badge class="badge badge-primary">Paypal</badge>';
    }


}

function order_status($order_status = 0)
{

    if (trim($order_status) == 0) {
        return '<label class="badge badge-xs badge-warning text-uppercase">Waiting for Payment</label>';
    }

    if (trim($order_status) == 5) {
        return '<label class="badge badge-xs badge-danger text-uppercase">Cancelled</label>';
    }

    if (trim($order_status) == 4) {
        return '<label class="badge badge-xs badge-success text-uppercase">Completed</label>';
    }

    if (trim($order_status) == 3) {
        return '<label class="badge badge-xs badge-info text-uppercase">Delivered</label>';
    }

    if (trim($order_status) == 2) {
        return '<label class="badge badge-xs badge-primary text-uppercase">Order Processing</label>';
    }

    if (trim($order_status) == 1) {
        return '<label class="badge badge-xs badge-warning text-uppercase">Order Placed</label>';
    }
}

function order_status_ar($order_status = 0)
{
    $status = array(0 => 'Waiting for Payment', 1 => 'Order Placed', 2 => 'In Processing', 3 => 'Delivered', 4 => 'Completed', 5 => 'Cancelled');

    return $status[$order_status];
}

function quote_status($quote_status = 0)
{

    if (trim($quote_status) == 0) {
        return '<label class="badge badge-xs badge-warning">Unanswered</label>';
    }

    if (trim($quote_status) == 1) {
        return '<label class="badge badge-xs badge-primary">Answered</label>';
    }

    if (trim($quote_status) == 2) {
        return '<label class="badge badge-xs badge-success">Order Placed</label>';
    }

    if (trim($quote_status) == 3) {
        return '<label class="badge badge-xs badge-danger">Cancelled</label>';
    }
}

function payment_status($payment_status = 0)
{

    if (trim($payment_status) == 0) {
        return '<label class="badge badge-xs badge-danger">Unpaid</label>';
    }

    if (trim($payment_status) == 1) {
        return '<label class="badge badge-xs badge-success">Paid</label>';
    }
}

function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR']    = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } else if (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}

function getLastNDays($days, $format = 'd/m')
{
    $m         = date("m");
    $de        = date("d");
    $y         = date("Y");
    $dateArray = array();
    for ($i = 0; $i <= $days - 1; $i++) {
        $dateArray[str_replace(' ', '', date($format, mktime(0, 0, 0, $m, ($de - $i), $y)))]['day']   = date($format, mktime(0, 0, 0, $m, ($de - $i), $y));
        $dateArray[str_replace(' ', '', date($format, mktime(0, 0, 0, $m, ($de - $i), $y)))]['total'] = 0;
    }

    return array_reverse($dateArray);
}

function CalcPercentage($total, $percent)
{
    $val = ($total != 0) ? round(($percent / $total) * 100, 2) : 0;
    return $val;
}

function valueByPercent($total, $percent)
{
    $val = round(($percent * $total) / 100, 3);
    return $val;
}

function CalcPercentValue($total, $percent)
{
    $val = ($percent * $total) / 100;
    return $val;
}

function CalcOrderCost($post)
{
    if (empty($post)) return 0;

    $ci_this       = &get_instance();
    $deadline      = explode(' ', $post['deadline']);
    $duration      = trim($deadline[0]);
    $duration_type = trim($deadline[1]);
    $where         = 'duration = "' . $duration . '" AND duration_type = "' . $duration_type . '" AND type = "writing"';

    $packages = $ci_this->common_model->getTableData('packages', '*', $where);
    if (!empty($packages)) {
        $academic_level = str_replace(' ', '_', strtolower(trim($post['academic_level'])));
        return $packages[0]->$academic_level * $post['no_of_pages'];
    }
    return 0;
}

function CountAllOrders($status = NULL)
{
    $ci_this = &get_instance();
    $where   = 'order_id != 0';

    if ($status != NULL) {
        $where .= ' AND status = ' . $status;
    }

    $orders = $ci_this->common_model->getTableData('orders', 'COUNT(1) as total', $where);
    return (!empty($orders) && $orders[0]->total != '') ? round($orders[0]->total, 2) : 0;
}

function Discount_Percentage($user_id = 0, $amount = 0)
{
    $ci_this        = &get_instance();
    $order_discount = array(1 => 10, 4 => 20);
    $orders         = $ci_this->common_model->getTableData('orders', 'COUNT(1) as total', 'user_id = ' . $user_id . ' AND status NOT IN (5)');//completed orders
    $discount       = 0;
    if (isset($order_discount[$orders[0]->total])) {
        return $order_discount[$orders[0]->total];//valueByPercent($amount, $order_discount[$orders[0]->total]);
    } else {
        $month_orders = $ci_this->common_model->getTableData('orders', 'SUM(amount_received) as total', 'DATE_FORMAT(orders.added_on,"%Y-%m")= "' . date('Y-m') . '" AND user_id = ' . $user_id . ' AND orders.status IN (4)', '', '', 'payments', 'payments.order_id = orders.order_id');//completed orders
        $total_amount = !empty($month_orders) && $month_orders[0]->total != '' ? $month_orders[0]->total : 0;
        $discount     = $total_amount > 3000 ? 12 : 0;
    }
    return $discount;
}

function SumPayments($status = 1)
{
    $ci_this  = &get_instance();
    $where    = 'status = ' . $status . '';
    $payments = $ci_this->common_model->getTableData('payments', 'SUM(amount) as amount, SUM(amount_received) as amount_received', $where);
    return $payments[0];
}

function ConvertCurrency($amount, $from, $to)
{
    $req_url       = 'https://api.exchangerate-api.com/v4/latest/' . $from;
    $response_json = file_get_contents($req_url);
    // Continuing if we got a result
    if (FALSE !== $response_json) {
        // Try/catch for json_decode operation
        try {
            // Decoding
            $response_object = json_decode($response_json);
            // YOUR APPLICATION CODE HERE, e.g.
            return round(($amount * $response_object->rates->$to), 2);
        } catch (Exception $e) {
            // Handle JSON parse error...
            return 0;
        }
    }
    return 0;
}

?>