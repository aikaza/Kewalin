<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueWith implements Rule
{
    private $colname;
    private $table;
    private $val;
    private $custom_attribute;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $colname, $val,$custom_attribute = null)
    {
        $this->table = $table;
        $this->colname = $colname;
        $this->val = $val;
        $this->custom_attribute = $custom_attribute;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $col_to_check = ($this->custom_attribute === null) ? $attribute : 
        $this->custom_attribute;
        $res = $this->table->where($this->colname,$this->val)
                    ->where($col_to_check,$value)
                    ->first();
        if($res === null) return true;            
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute and '.$this->colname.' must be unique';
    }
}
