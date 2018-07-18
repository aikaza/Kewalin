<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function test()
    {
        function testRecusive($arr)
        {
            array_splice($arr, 0, 3);
            echo "test<br>";
            if (count($arr) > 0) {
                testRecusive($arr);
            }
        }
        testRecusive(['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i']);
    }

    public function testRecusive($arr)
    {
        array_splice($arr, 0, 3);
        echo "test<br>";
        if (count($arr) > 0) {
            testRecusive($arr);
        }
    }
}
