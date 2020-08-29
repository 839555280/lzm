<?php
if (! function_exists('error')) {
    function error($message)
    {
        $message = new \Illuminate\Support\MessageBag([$message]);
        echo "<script>alert('".$message."')</script>";
    }
}
