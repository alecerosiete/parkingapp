<?php

/*
 * Permite almacenar todas sus reglas de validación para toda su aplicación en un archivo de configuración. 
 * Puede organizar estas reglas en "grupos". Estos grupos pueden cargarse sea en forma automática cuando se llama 
 * un controlador/función coincidente, o manualmente llamando a cada una según se necesite. 
 */

$config = array(
  'new_profile' => array(
    array(
      'field' => 'username',
      'label' => 'E-mail',
      'rules' => 'trim|required|valid_email|callback_check_username'
    ),
    array(
      'field' => 'fullname',
      'label' => 'Nombre Completo',
      'rules' => 'trim|required|min_length[2]'
    ),
    array(
      'field' => 'phone',
      'label' => 'Telefono',
      'rules' => 'trim|min_length[9]|numeric'
    ),
    array(
      'field' => 'usergroup',
      'label' => 'Grupo',
      'rules' => 'required|callback_check_usergroup'
    ),
    array(
      'field' => 'userpass',
      'label' => 'Contrase&ntilde;a',
      'rules' => 'trim|required|min_length[4]'
    ),
    array(
      'field' => 'retryUserpass',
      'label' => 'Repetir Contrase&ntilde;a',
      'rules' => 'trim|required|matches[userpass]'
    )
  ),
  'update_profile' => array(
    array(
      'field' => 'fullname',
      'label' => 'Nombre Completo',
      'rules' => 'trim|required|min_length[2]'
    ),
    array(
      'field' => 'phone',
      'label' => 'Telefono',
      'rules' => 'trim|min_length[9]|numeric'
    )
  ),
  'register' => array(
    array(
      'field' => 'name',
      'label' => 'Nombre',
      'rules' => 'trim|required|min_length[2]'
    ),
    array(
      'field' => 'phone',
      'label' => 'Telefono',
      'rules' => 'trim|min_length[9]|numeric'
    ),
    array(
      'field' => 'email',
      'label' => 'Email',
      'rules' => 'required|valid_email'
    ),
    array(
      'field' => 'terms',
      'label' => 'Terminos y Condiciones',
      'rules' => 'required|regex_match[/1/]'
    )
  ),
  'usergroups' => array(
    array(
      'field' => 'id',
      'label' => 'Identificador',
      'rules' => 'trim|required|min_length[5]|max_length[20]'
    ),
    array(
      'field' => 'name',
      'label' => 'Nombre del Grupo',
      'rules' => 'trim|required|min_length[5]|max_length[100]'
    )
  ),
  'users' => array(
    array(
      'field' => 'username',
      'label' => 'Identificador',
      'rules' => 'trim|required|min_length[5]|max_length[20]'
    ),
    array(
      'field' => 'userpass',
      'label' => 'Nueva contraseña',
      'rules' => 'trim|required|matches[confirmpass]|min_length[4]'
    ),
    array(
      'field' => 'confirmpass',
      'label' => 'Confirmar contraseña',
      'rules' => 'trim|required|min_length[4]|'
    ),
    array(
      'field' => 'usergroup',
      'label' => 'Grupo de Usuario',
      'rules' => 'trim|required|min_length[5]|max_length[20]'
    ),
    array(
      'field' => 'fullname',
      'label' => 'Nombre de Usuario',
      'rules' => 'trim|required|min_length[5]|max_length[100]'
    ),
    array(
      'field' => 'phone',
      'label' => 'Telefono',
      'rules' => 'trim|min_length[11]'
    ),
    array(
      'field' => 'email',
      'label' => 'E-mail',
      'rules' => 'trim|valid_email'
    )
  ),
  'account' => array(
    array(
      'field' => 'fullname',
      'label' => 'Nombre Completo',
      'rules' => 'trim|required|min_length[5]'
    ), array(
      'field' => 'phone',
      'label' => 'Numero de Telefono',
      'rules' => 'trim|min_length[9]'
    ), array(
      'field' => 'email',
      'label' => 'E-mail',
      'rules' => 'trim|valid_email'
    )
  ),
  'change_pwd' => array(
    array(
      'field' => 'userpass',
      'label' => 'Nueva contraseña',
      'rules' => 'trim|required|matches[retryPassword]|min_length[4]'
    ),
    array(
      'field' => 'retryPassword',
      'label' => 'Confirmar contraseña',
      'rules' => 'trim|required|min_length[4]'
    )
  ),
  'rate' => array(
    array(
      'field' => 'vehicleType',
      'label' => 'Tipo de Vehiculo',
      'rules' => 'trim|required'
    ),
    array(
      'field' => 'name',
      'label' => 'Nombre',
      'rules' => 'trim|required'
    ),
    array(
      'field' => 'price',
      'label' => 'Costo',
      'rules' => 'trim|required'
    ),
    array(
      'field' => 'description',
      'label' => 'Descripcion',
      'rules' => 'trim|min_length[2]'
    ),
    array(
      'field' => 'rateType',
      'label' => 'Tipo de Tarifa',
      'rules' => 'trim|min_length[1]|required'
    )
  ),
  'config' => array(
    array(
      'field' => 'defaultPrice',
      'label' => 'Tarifa por Defecto',
      'rules' => 'trim|required'
    ),
    array(
        'field' => 'company',
      'label' => 'Empresa o Razon Social',
      'rules' => 'trim|min_length[2]'
    ),
    array(
        'field' => 'address',
      'label' => 'Dirección',
      'rules' => 'trim|min_length[2]'
    ),
    array(
        'field' => 'phone',
      'label' => 'Teléfono',
      'rules' => 'trim|min_length[6]'
    ),
    array(
        'field' => 'ruc',
      'label' => 'Ruc',
      'rules' => 'trim|min_length[6]'
    )
  ),
  'vehicles' => array(
    array(
      'field' => 'name',
      'label' => 'Nombre',
      'rules' => 'trim|required|min_length[2]'
    )
  ),
  'clients' => array(
    array(
      'field' => 'name',
      'label' => 'Nombre',
      'rules' => 'trim|required'
    ),array(
      'field' => 'email',
      'label' => 'Email',
      'rules' => 'trim'
    ),array(
      'field' => 'phone',
      'label' => 'Telefono',
      'rules' => 'trim'
    ),array(
      'field' => 'description',
      'label' => 'Descripci&oacute;n',
      'rules' => 'trim'
    ),array(
      'field' => 'rfid',
      'label' => 'Codigo de la Tarjeta',
      'rules' => 'trim|required'
    ),array(
      'field' => 'vehicleType',
      'label' => 'Tipo de Vehiculo',
      'rules' => 'trim|required'
    ),array(
      'field' => 'rate',
      'label' => 'Tarifa',
      'rules' => 'trim|required'
    ),array(
      'field' => 'dateTime',
      'label' => 'Fecha / Hora Caducidad de Tarjeta',
      'rules' => 'trim|required'
    )
  )
);
