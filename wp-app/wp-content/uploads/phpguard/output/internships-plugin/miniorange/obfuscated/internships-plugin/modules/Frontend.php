<?php


namespace internships\Internships;

class Frontend
{
    function __construct()
    {
        add_action("\167\160\x5f\x65\156\x71\x75\x65\x75\x65\x5f\x73\143\x72\151\x70\x74\x73", array($this, "\162\x65\x67\x69\163\x74\x65\x72\137\x61\x73\163\145\164\x73"));
    }
    function register_assets()
    {
        $this->add_script("\x6d\x61\151\x6e");
        $this->add_style("\x6d\141\151\156");
    }
    private function add_style($fuJUR)
    {
        wp_register_style(__NAMESPACE__ . "\55\163\x74\171\x6c\x65\55{$fuJUR}", plugins_url("\x2f\56\56\57\163\x74\x79\x6c\x65\x73\150\145\145\164\x73\57{$fuJUR}\56\143\163\163", __FILE__));
        wp_enqueue_style(__NAMESPACE__ . "\x2d\163\x74\x79\154\x65\x2d{$fuJUR}");
    }
    private function add_script($fuJUR, $Hhq0J = array(), $OxYP3 = "\x31\x2e\x30", $Vnqa_ = true)
    {
        wp_register_script(__NAMESPACE__ . "\55\163\143\162\x69\160\164\x2d{$fuJUR}", plugins_url("\57\x2e\x2e\57\x73\143\x72\151\160\164\163\57{$fuJUR}\56\x6a\163", __FILE__), $Hhq0J, $OxYP3, $Vnqa_);
        wp_enqueue_script(__NAMESPACE__ . "\55\163\x63\x72\x69\x70\x74\x2d{$fuJUR}");
    }
}
