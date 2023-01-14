<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?php echo base_url('admin/dashboard'); ?>" class="brand-link" style="display: flex; flex-direction: row; margin-left: 12px;">
    <img alt="logo" class="mb-2 img-circle elevation-2 mr-2" src="/assets/templates/adminlte320/img/img-earth.jpg" height="35" width="35"><br>
    <span class="brand-text font-weight-light mt-1">Hallyu Sampah!</span>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <?php if ($photo == '') { ?>
          <img src="/images/user/no_image.gif" class="img-circle elevation-2" alt="User Image">
        <?php
        } else { ?>
          <img src="/images/user/<?= $photo; ?>" class="img-circle elevation-2" alt="User Image">
        <?php
        } ?>
      </div>
      <div class="info">
        <a href="#" class="d-block"><?= $user_name; ?></a>
      </div>
    </div>

    <!-- Admin -->
    <?php if ($level == 'Admin') { ?>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?php echo base_url('admin/dashboard'); ?>" class="nav-link <?php if ($page == 'dashboard') echo " active";  ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url('admin/transaksi-penarikan'); ?>" class="nav-link <?php if ($page == 'transaksi-penarikan') echo " active";  ?>">
            <i class="nav-icon fas fa-hand-holding-usd"></i>
            <p>Transaksi Penarikan</p>
          </a>
        </li>
        <li class="nav-item <?php if ($menu == 'data_sampah') echo " menu-open";  ?>">
          <a href="#" class="nav-link <?php if ($menu == 'data_sampah') echo " active";  ?>">
            <i class="nav-icon fas fa-trash-alt"></i>
            <p>Data Sampah
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/sampah'); ?>" class="nav-link <?php if ($page == 'sampah') echo " active";  ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Sampah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/jenis'); ?>" class="nav-link <?php if ($page == 'jenis') echo " active";  ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Jenis</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/satuan'); ?>" class="nav-link <?php if ($page == 'satuan') echo " active";  ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Satuan</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url('admin/nasabah'); ?>" class="nav-link <?php if ($page == 'nasabah') echo " active";  ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Data Nasabah</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url('admin/profil'); ?>" class="nav-link <?php if ($page == 'profil') echo " active";  ?>">
            <i class="nav-icon fas fa-user-cog"></i>
            <p>Pengaturan Profil</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url('admin/user'); ?>" class="nav-link <?php if ($page == 'user') echo " active";  ?>">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>Managemen User</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="javascript:void(0);" class="nav-link" id="logout">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Log Out</p>
          </a>
        </li>
      </ul>
    </nav>

    <!-- Staff -->
    <?php } else if ($level == 'Staff') { ?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo base_url('admin/dashboard'); ?>" class="nav-link <?php if ($page == 'dashboard') echo " active";        ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('admin/setor-sampah'); ?>" class="nav-link <?php if ($page == 'setor-sampah') echo " active";        ?>">
              <i class="nav-icon fas fa-trash-alt"></i>
              <p>Data Setor Sampah</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('admin/profil'); ?>" class="nav-link <?php if ($page == 'profil') echo " active";        ?>">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>Pengaturan Profil</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="javascript:void(0);" class="nav-link" id="logout">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Log Out</p>
            </a>
          </li>
        </ul>
      </nav>
    <?php } ?>
  </div>
</aside>