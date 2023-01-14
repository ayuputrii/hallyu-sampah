<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation extends BaseConfig
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    // Validation Login
    public $login = [
        'username' => [
            'label'  => 'Username',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Username Tidak Boleh Kosong!'
            ]
        ],
        'password' => [
            'label'  => 'Password',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Password Tidak Boleh Kosong!'
            ]
        ]
    ];

    // Validation Register
    public $register = [
        'customer_name' => [
            'label'  => 'Nama Lengkap',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama Lengkap Tidak Boleh Kosong!'
            ]
        ],
        'username' => [
            'label'  => 'Username',
            'rules'  => 'required|is_unique[tb_customers.username]',
            'errors' => [
                'required'  => 'Username Tidak Boleh Kosong!',
                'is_unique' => 'Username sudah pernah digunakan!'
            ]
        ],
        'password' => [
            'label'  => 'Password',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Password Tidak Boleh Kosong!'
            ]
        ],
    ];

    // Validation Rubbish
    public $rubbish = [
        'rubbish_name' => [
            'label'  => 'Nama Sampah',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama Sampah tidak boleh kosong!'
            ]
        ],
        'id_type' => [
            'label'  => 'Jenis Sampah',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Jenis Sampah tidak boleh kosong!'
            ]
        ],
        'id_unit' => [
            'label'  => 'Satuan',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Satuan tidak boleh kosong!'
            ]
        ],
        'desc' => [
            'label'  => 'Deskripsi',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Deskripsi tidak boleh kosong!'
            ]
        ],
        'price' => [
            'label'  => 'Harga',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Harga tidak boleh kosong!'
            ]
        ],
        'stock' => [
            'label'  => 'Stok',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Stok tidak boleh kosong!'
            ]
        ],
        'photo' => [
            'label'  => 'Foto',
            'rules'  => 'max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/gif]',
            'errors' => [
                'max_size' => 'Ukuran File Foto maksimal 2MB!',
                'is_image' => 'Yang anda pilih bukan gambar!',
                'mime_in'  => 'Format Foto tidak sesuai!'
            ]
        ]
    ];

    // Validation Jenis
    public $type = [
        'type_name' => [
            'label'  => 'Nama Jenis',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama Jenis Tidak Boleh Kosong!'
            ]
        ]
    ];

    // Validation Satuan
    public $unit = [
        'unit_name' => [
            'label'  => 'Nama Satuan',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama Satuan Tidak Boleh Kosong!'
            ]
        ]
    ];

    // Validation Data user
    public $add_user = [
        'user_name' => [
            'label'  => 'Nama User',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama User tidak boleh kosong!'
            ]
        ],
        'username' => [
            'label'  => 'Username',
            'rules'  => 'required|is_unique[tb_users.username]',
            'errors' => [
                'required'  => 'Username Tidak Boleh Kosong!',
                'is_unique' => 'Username sudah pernah digunakan!'
            ]
        ],
        'password' => [
            'label'  => 'Password',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Password tidak boleh kosong!'
            ]
        ],
        'level' => [
            'label'  => 'Level',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Level tidak boleh kosong!'
            ]
        ],
        'photo' => [
            'label'  => 'Foto',
            'rules'  => 'max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/gif]',
            'errors' => [
                'max_size' => 'Ukuran File Foto maksimal 2MB!',
                'is_image' => 'Yang anda pilih bukan gambar!',
                'mime_in'  => 'Format Foto tidak sesuai!'
            ]
        ]
    ];
    public $update_user = [
        'user_name' => [
            'label'  => 'Nama User',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama User tidak boleh kosong!'
            ]
        ],
        'username' => [
            'label'  => 'Username',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Username tidak boleh kosong!'
            ]
        ],
        'level' => [
            'label'  => 'Level',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Level tidak boleh kosong!'
            ]
        ],
        'photo' => [
            'label'  => 'Foto',
            'rules'  => 'max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/gif]',
            'errors' => [
                'max_size' => 'Ukuran File Foto maksimal 2MB!',
                'is_image' => 'Yang anda pilih bukan gambar!',
                'mime_in'  => 'Format Foto tidak sesuai!'
            ]
        ]
    ];

    public $profile_admin = [
        'user_name' => [
            'label'  => 'Nama User',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama User tidak boleh kosong!'
            ]
        ],
        'username' => [
            'label'  => 'Username',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Username tidak boleh kosong!'
            ]
        ],
        'level' => [
            'label'  => 'Level',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Level tidak boleh kosong!'
            ]
        ],
        'photo' => [
            'label'  => 'Foto',
            'rules'  => 'max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/gif]',
            'errors' => [
                'max_size' => 'Ukuran File Foto maksimal 2MB!',
                'is_image' => 'Yang anda pilih bukan gambar!',
                'mime_in'  => 'Format Foto tidak sesuai!'
            ]
        ]
    ];

    public $profile_user = [
        'customer_name' => [
            'label'  => 'Nama Nasabah',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama Nasabah tidak boleh kosong!'
            ]
        ],
        'username' => [
            'label'  => 'Username',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Username tidak boleh kosong!'
            ]
        ],
        'address' => [
            'label'  => 'Alamat',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Alamat tidak boleh kosong!'
            ]
        ],
        'phone' => [
            'label'  => 'Telepon',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Telepon tidak boleh kosong!'
            ]
        ],        
        'photo' => [
            'label'  => 'Foto',
            'rules'  => 'max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/gif]',
            'errors' => [
                'max_size' => 'Ukuran File Foto maksimal 2MB!',
                'is_image' => 'Yang anda pilih bukan gambar!',
                'mime_in'  => 'Format Foto tidak sesuai!'
            ]
        ]
    ];

    // Validation transaksi setor sampah
    public $rubbish_deposit_user = [
        'id_rubbish' => [
            'label'  => 'Nama Sampah',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama Sampah tidak boleh kosong!'
            ]
        ],
        'total_deposit' => [
            'label'  => 'Jumlah',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Jumlah tidak boleh kosong!'
            ]
        ],
        'total' => [
            'label'  => 'Total',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Total tidak boleh kosong!'
            ]
        ],
        'date_delivery' => [
            'label'  => 'Tgl. Penjemputan',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Tgl. Penjemputan tidak boleh kosong!'
            ]
        ]
    ];

    // Validasi transaksi setor sampah
    public $rubbish_deposit_admin = [
        'status' => [
            'label'  => 'Status',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Status tidak boleh kosong!'
            ]
        ],
    ];

    // Validation transaction
    public $transaction_user = [
        'id_account' => [
            'label'  => 'Rekening',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Rekening tidak boleh kosong!'
            ]
        ],
        'total' => [
            'label'  => 'Jumlah',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Jumlah tidak boleh kosong!'
            ]
        ],
    ];

    // Validation transaction
    public $transaction_admin = [
        'status' => [
            'label'  => 'Status',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Status tidak boleh kosong!'
            ]
        ],
    ];

    // Validation Account Bank
    public $account = [
        'bank_name' => [
            'label'  => 'Nama Bank',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama Bank tidak boleh kosong!'
            ]
        ],
        'account_number' => [
            'label'  => 'No. Rekening',
            'rules'  => 'required',
            'errors' => [
                'required' => 'No. Rekening tidak boleh kosong!'
            ]
        ],
        'the_name_of' => [
            'label'  => 'Atas Nama',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Atas Nama tidak boleh kosong!'
            ]
        ]
    ];

    // Validation Customers
    public $update_customer = [
        'customer_name' => [
            'label'  => 'Nama Nasabah',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama Nasabah tidak boleh kosong!'
            ]
        ],
        'address' => [
            'label'  => 'Alamat',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Alamat tidak boleh kosong!'
            ]
        ],
        'phone' => [
            'label'  => 'Telepon',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Telepon tidak boleh kosong!'
            ]
        ],
        'photo' => [
            'label'  => 'Foto',
            'rules'  => 'max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/gif]',
            'errors' => [
                'max_size' => 'Ukuran File Foto maksimal 2MB!',
                'is_image' => 'Yang anda pilih bukan gambar!',
                'mime_in'  => 'Format Foto tidak sesuai!'
            ]
        ]
    ];
}
