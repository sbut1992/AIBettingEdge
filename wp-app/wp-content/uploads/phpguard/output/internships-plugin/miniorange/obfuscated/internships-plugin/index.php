<?php
/*
Plugin Name: Internships
Version: 0.0.3
*/


namespace internships\Internships;

class Base
{
    public static $options = array("\163\157\155\145\x54\145\170\x74\x4f\x70\x74\151\157\156" => array("\151\144" => "\x69\156\x74\x65\x72\x6e\163\x68\x69\x70\x73\134\x49\x6e\164\x65\162\x6e\163\x68\151\x70\163\x2d\x70\x6f\x69\x6e\x74\x2d\x77\x65\x69\147\x68\164", "\164\x69\164\x6c\x65" => "\120\x6f\151\156\x74\40\x77\x65\151\x67\150\x74", "\164\171\160\x65" => "\x74\x65\170\164", "\x64\145\146\141\165\154\x74" => 1));
    function __construct()
    {
        spl_autoload_register(array($this, "\x70\154\165\x67\151\x6e\x5f\141\165\x74\157\154\x6f\141\144\x65\162"));
        register_activation_hook(__FILE__, array($this, "\141\x63\x74\151\166\141\x74\145\137\160\154\165\147\x69\x6e"));
        if (!Helper::in_backend()) {
            goto uTRBH;
        }
        new Backend();
        uTRBH:
        if (Helper::in_backend()) {
            goto syaCB;
        }
        new Frontend();
        syaCB:
    }
    function plugin_autoloader($Qeg2K)
    {
        $w7JJY = dirname(__FILE__);
        $zwMxG = explode("\134", $Qeg2K);
        $AM1VL = $zwMxG[count($zwMxG) - 1];
        if (!file_exists("{$w7JJY}\x2f\x6d\x6f\x64\x75\x6c\x65\163\57{$AM1VL}\56\160\150\160")) {
            goto H1T2e;
        }
        require_once "{$w7JJY}\57\x6d\157\x64\165\x6c\x65\x73\57{$AM1VL}\x2e\x70\x68\x70";
        H1T2e:
    }
    function activate_plugin()
    {
        foreach (Base::$options as $uKhXv) {
            if (!($uKhXv["\144\x65\x66\x61\x75\x6c\x74"] && null !== get_option($uKhXv["\x69\x64"]))) {
                goto Z4FkP;
            }
            update_option($uKhXv["\151\x64"], $uKhXv["\x64\x65\x66\x61\x75\x6c\164"]);
            Z4FkP:
            LDp1I:
        }
        unx2D:
    }
}
new Base();
