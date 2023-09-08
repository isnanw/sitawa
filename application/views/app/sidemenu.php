<!-- MAIN NAVIGATION -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<nav id="mainnav-container" class="mainnav">
    <div class="mainnav__inner">

        <!-- Navigation menu -->
        <div class="mainnav__top-content scrollable-content pb-5">

            <!-- Profile Widget -->
            <div class="mainnav__profile mt-3 d-flex3">

                <div class="mt-2 d-mn-max"></div>

                <!-- Profile picture  -->

                <div class="mininav-toggle text-center py-2">
                    <?php
                            $sql = "SELECT uname,gambar FROM pengguna WHERE uname = '".$this->session->userdata('user')['uname']."'";
                            // die($sql);
                            $query = $this->db->query($sql);
                            $gambar = "";
                            if ($query->num_rows() > 0) {
                                    foreach ($query->result() as $row) {
                                            $gambar = $row->gambar;
                                    }
                            }
                            if($gambar != Null){
                                $pp = $gambar;
                            }else{
                                $pp = '3.png';
                            }

                    ?>
                        <!-- <img class="mainnav__avatar img-md rounded-circle border" src="<?=base_url();?>assets/v3.0.1/assets/img/profile-photos/3.png" alt="Profile Picture"> -->
                        <img class="mainnav__avatar img-md rounded-circle border" src="<?= base_url('uploads/').$pp ?>" alt="Profile Picture" loading="lazy">
                </div>

                <div class="mininav-content collapse d-mn-max">
                    <div class="d-grid">

                        <!-- User name and position -->
                        <button class="d-block btn shadow-none p-2" data-bs-toggle="collapse" data-bs-target="#usernav" aria-expanded="false" aria-controls="usernav">
                            <span class="dropdown-toggle d-flex justify-content-center align-items-center">
                                <h6 class="mb-0 me-3"><?=$this->session->userdata('user')['nama']?></h6>
                            </span>
                            <small class="text-muted"><?=$this->session->userdata('user')['uname']?></small>
                        </button>

                        <!-- Collapsed user menu -->
                        <div id="usernav" class="nav flex-column collapse">

                            <a href="<?=base_url('profil');?>" class="nav-link">
                                <i class="demo-pli-male fs-5 me-2"></i>
                                <span class="ms-1">Profile</span>
                            </a>

                            <a href="<?=base_url('auth/logout');?>" class="nav-link">
                                <i class="demo-pli-unlock fs-5 me-2"></i>
                                <span class="ms-1">Logout</span>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
            <!-- End - Profile widget -->

            <!-- Navigation Category -->
            <div class="mainnav__categoriy py-3">
                <h6 class="mainnav__caption mt-0 px-3 fw-bold">Home</h6>
                <ul class="mainnav__menu nav flex-column">

                    <!-- Link with submenu -->
                    <li class="nav-item">

                        <a href="<?=base_url('mainku/dashboard');?>" class="nav-link mininav-toggle <?= $this->uri->segment(2) == 'dashboard' ? 'active' : ''; ?>"><i class="demo-pli-home fs-5 me-2"></i>
                            <span class="nav-label mininav-content ms-1">Dashboard</span>
                        </a>

                    </li>
                    <!-- END : Link with submenu -->

                </ul>
            </div>
            <!-- END : Navigation Category -->

            <!-- Components Category -->
            <div class="mainnav__categoriy py-3">
                <h6 class="mainnav__caption mt-0 px-3 fw-bold">Menu</h6>
                <ul class="mainnav__menu nav flex-column">
                <?php
                    foreach ($this->session->userdata('menu') as $menu) {
                    $link = $menu['url'];
                    $aktive = $this->uri->segment(1) == $link;
                ?>
                    <!-- Link with submenu has-sub -->
                    <li class="nav-item">

                        <a href="<?= base_url($menu['url']); ?>" class="nav-link mininav-toggle <?= $aktive ? 'active' : ''; ?>"><i class="<?=$menu['icon'];?> fs-5 me-2"></i>
                            <span class="nav-label mininav-content ms-1"><?=$menu['title'];?></span>
                        </a>

                    </li>
                    <!-- END : Link with submenu -->
                    <?php
                        }
                    ?>

                </ul>
            </div>
            <!-- END : Components Category -->

        </div>
        <!-- End - Navigation menu -->

        <!-- Bottom navigation menu -->
        <div class="mainnav__bottom-content border-top pb-2">
            <ul id="mainnav" class="mainnav__menu nav flex-column">
                <li class="nav-item has-sub">
                    <a href="#" class="nav-link mininav-toggle collapsed" aria-expanded="false">
                        <i class="demo-pli-unlock fs-5 me-2"></i>
                        <span class="nav-label ms-1">Logout</span>
                    </a>
                    <ul class="mininav-content nav flex-column collapse">
                        <li class="nav-item">
                            <a href="<?=base_url('auth/logout');?>" class="nav-link">This device only</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link disabled" tabindex="-1" aria-disabled="true">All Devices</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Lock screen</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- End - Bottom navigation menu -->

    </div>
</nav>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- END - MAIN NAVIGATION -->

</div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - PAGE CONTAINER -->