<!-- HEADER -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<header class="header">
    <div class="header__inner">

        <!-- Brand -->
        <div class="header__brand">
            <div class="brand-wrap">

                <!-- Brand logo rand-img-->

                <a href="<?= base_url(); ?>" class="brand-img stretched-link">
                                    <img src="<?= base_url(); ?>assets/img/lgsj.png" alt="Logo" class="" width="100" height="40">
                                </a>


                <!-- Brand title -->
                <div class="brand-title"><img src="<?= base_url(); ?>assets/img/lgtulwt.png" alt="Logo" class="" width="100"
                        height="30"></div>

                <!-- You can also use IMG or SVG instead of a text element. -->

            </div>
        </div>
        <!-- End - Brand -->

        <div class="header__content">

            <!-- Content Header - Left Side: -->
            <div class="header__content-start">

                <!-- Navigation Toggler -->
                <button type="button" class="nav-toggler header__btn btn btn-icon btn-sm" aria-label="Nav Toggler">
                    <i class="demo-psi-view-list"></i>
                </button>

                <!-- Searchbox -->
                <div class="header-searchbox">

                    <!-- Searchbox toggler for small devices -->
                    <label for="header-search-input" class="header__btn d-md-none btn btn-icon rounded-pill shadow-none border-0 btn-sm" type="button">
                        <i class="demo-psi-magnifi-glass"></i>
                    </label>

                    <!-- Searchbox input -->
                    <form class="searchbox searchbox--auto-expand searchbox--hide-btn input-group">
                        <input id="header-search-input" class="searchbox__input form-control bg-transparent" type="search" placeholder="Search . . ." aria-label="Search">
                        <div class="searchbox__backdrop">
                            <button class="searchbox__btn header__btn btn btn-icon rounded shadow-none border-0 btn-sm" type="button" id="button-addon2">
                                <i class="demo-pli-magnifi-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End - Content Header - Left Side -->

            <!-- Content Header - Right Side: -->
            <div class="header__content-end">

                <!-- Notification Dropdown -->

                <!-- End - Notification dropdown -->

                <!-- User dropdown -->
                <div class="dropdown">

                    <!-- Toggler -->
                    <button class="header__btn btn btn-icon btn-sm" type="button" data-bs-toggle="dropdown" aria-label="User dropdown" aria-expanded="false">
                        <i class="demo-psi-male"></i>
                    </button>

                    <!-- User dropdown menu -->
                    <div class="dropdown-menu dropdown-menu-end w-md-300px">

                        <!-- User dropdown header -->
                        <div class="d-flex align-items-center border-bottom px-3 py-2">
                            <div class="flex-shrink-0">
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
											<img class="img-sm rounded-circle" src="<?= base_url('uploads/').$pp ?>" alt="Profile Picture" loading="lazy">
									</div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0"><?=$this->session->userdata('user')['nama']?></h5>
                                <span class="text-muted fst-italic"><?=$this->session->userdata('user')['uname']?></span>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12">

                                <!-- User menu link -->
                                <div class="list-group list-group-borderless h-100 py-3">
                                    <!-- <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <span><i class="demo-pli-mail fs-5 me-2"></i> Messages</span>
                                        <span class="badge bg-danger rounded-pill">14</span>
                                    </a> -->
                                    <a href="<?=base_url('profil');?>" class="list-group-item list-group-item-action">
                                        <i class="demo-pli-male fs-5 me-2"></i> Profile
                                    </a>
                                    <!-- <a href="#" class="list-group-item list-group-item-action">
                                        <i class="demo-pli-gear fs-5 me-2"></i> Settings
                                    </a>

                                    <a href="#" class="list-group-item list-group-item-action mt-auto">
                                        <i class="demo-pli-computer-secure fs-5 me-2"></i> Lock screen
                                    </a> -->
                                    <a href="<?=base_url('auth/logout');?>" class="list-group-item list-group-item-action">
                                        <i class="demo-pli-unlock fs-5 me-2"></i> Logout
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <!-- End - User dropdown -->
            </div>
        </div>
    </div>
</header>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- END - HEADER -->