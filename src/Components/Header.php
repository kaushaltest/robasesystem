<?php
namespace role\rolebasesystem\Components;

use Illuminate\View\Component;

class Header extends Component
{
 
    public function render()
    {
        return view('rolebasesystem::components.header');
    }
}