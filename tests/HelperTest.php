<?php  namespace Palmabit\Library\Tests; 

/**
 * Test HelperTest
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
class HelperTest extends TestCase {

    /**
     * @test
     **/
    public function canGetArrayValue()
    {
        $array_value = "array value";
        $valid_key       = "key";
        $arr[$valid_key] = $array_value;

        $value = getValueItem($arr, $valid_key);
        $this->assertEquals($value, $array_value);

        $value = getValueItem($arr, "key_nonexistant");
        $this->assertNull($value);
    }

    /**
     * @test
     **/
    public function canGetObjectValue()
    {
        $obj_value = "array value";
        $valid_key       = "key";
        $obj = new \StdClass;
        $obj->$valid_key = $obj_value;

        $value = getValueItem($obj, $valid_key);
        $this->assertEquals($value, $obj_value);

        $default_value = "22";
        $value = getValueItem($obj, "key_nonexistant", $default_value);
        $this->assertEquals($value, $default_value);
    }
}
 