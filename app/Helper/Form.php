<?php

namespace App\Helper;

class Form
{
    public static function textarea($data = [])
    {
        $data['text'] = $data['text'] ?? $data['name'];
        $data['value'] = $data['value'] ?? '';

        return view('form.inputs.textarea', $data);
    }

    public static function date($data = [])
    {
        $data['text'] = $data['text'] ?? 'Date';
        $data['value'] = $data['value'] ?? '';

        return view('form.inputs.date', $data);
    }

    public static function file($data = [])
    {
        $data['file_path'] = $data['file_path'] ?? '';
        $data['file_name'] = $data['file_name'] ?? 'Choose file';
        $data['text'] = $data['text'] ?? $data['name'];
        $data['name'] = isset($data['multiple']) && $data['multiple'] === true ? $data['name'] . '[]' : $data['name'];

        return view('form.inputs.file', $data);
    }

    public static function input($data = [])
    {
        return view('form.inputs.text', $data);
    }

    public static function open($data = [])
    {
        $data['method_field'] = $data['method'];
        $data['method'] = strtoupper($data['method']) !== 'GET' ? 'POST' : strtoupper($data['method']);

        return view('form.form-open', $data);
    }

    public static function close($data = [])
    {
        return view('form.form-close', $data);
    }

}
