<?php


namespace internships\Internships;

class Helper
{
    public static function in_backend()
    {
        return is_admin() && (!defined("\104\x4f\111\116\x47\137\x41\x4a\x41\x58") || !DOING_AJAX);
    }
    public static function get_option($uKhXv)
    {
        return get_option(Base::$options[$uKhXv]["\151\144"]);
    }
    public static function render_template($fuJUR, $uKhXv = null)
    {
        include dirname(dirname(__FILE__)) . "\57\x74\145\155\160\x6c\141\164\x65\163\x2f{$fuJUR}\x2e\x70\x68\x70";
    }
}
