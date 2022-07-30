{{-- Header --}}
<li class="menu-header">Administrator&nbsp;&nbsp;|&nbsp;&nbsp;MIS</li>
{{-- Menu : หน้าหลัก --}}
<li class="nav-item" data-toggle="tooltip" data-placement="right">
    <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{url('home')}}">
        <i class="fas fa-home"></i>
        <span class="nav-link-text ml-2">หน้าหลัก</span>
    </a>
</li>
<li class="nav-item" data-toggle="tooltip" data-placement="right">
    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" 
    id="menu-a-mis-main"  href="javascript:;" data-parent="#menu-nav">
        <i class="fas fa-database"></i>
        <span class="nav-link-text ml-2">ข้อมูลหลัก</span>
    </a>
    <ul class="sidenav-second-level collapse
    @if(request()->is('admin/location') or request()->is('admin/type-asset*') 
    or request()->is('admin/department*') or request()->is('admin/employee*')
    ) show @endif"
    id="menu-a-mis-infosetup">
        <li class="{{ request()->is('admin/location*') ? 'active' : '' }}">
            <a href="{{url('admin/location')}}">จัดการข้อมูล Location</a>
        </li>    
        <li class="{{ request()->is('admin/type-asset*') ? 'active' : '' }}">
            <a href="{{url('admin/type-asset')}}">จัดการข้อมูลประเภททรัพย์สิน</a>
        </li>    
        <li class="{{ request()->is('admin/department*') ? 'active' : '' }}">
            <a href="{{url('admin/department')}}">จัดการข้อมูลฝ่าย</a>
        </li>    
        <li class="{{ request()->is('admin/employee*') ? 'active' : '' }}">
            <a href="{{url('admin/employee')}}">จัดการข้อมูลพนักงาน</a>
        </li>        
    </ul>
</li>