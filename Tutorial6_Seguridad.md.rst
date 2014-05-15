Autenticación
=============

Es posible usar la función header() para enviar un mensaje
"Authentication Required" al navegador del cliente causando que se abra
una ventana para ingresar usuario y password. Una vez se ha llenado el
usuario y password, la URL contenida dentro del script PHP será llamada
nuevamente con las variables predefinidas PHP\_AUTH\_USER,
PHP\_AUTH\_PW, y AUTH\_TYPE puestas por el nombre del usuario, password
y el tipo de autenticación respectivamente. Esas variables predefinidas
son encontradas en los arrays :math:`_SERVER y `\ HTTP\_SERVER\_VARS.

::

    <?php
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header('WWW-Authenticate: Basic realm="My Realm"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Texto a enviar si el usuario pulsa el botón Cancelar';
        exit;
    } else {
        echo "<p>Hola {$_SERVER['PHP_AUTH_USER']}.</p>";
        echo "<p>Tu ingresaste {$_SERVER['PHP_AUTH_PW']} como tu password.</p>";
    }
    ?>

Este ejemplo muestra como implementar un script PHP de autenticación
Digest

::

    <?php
    $realm = 'Area restringida';

    //user => password
    $users = array('admin' => 'mypass', 'guest' => 'guest');


    if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Digest realm="'.$realm.
               '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');

        die('Texto a enviar si el usuario pulsa el botón Cancelar');
    }


    // analiza la variable PHP_AUTH_DIGEST
    if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
        !isset($users[$data['username']]))
        die('Datos Erroneos!');


    // Generando una respuesta valida
    $A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
    $A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
    $valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

    if ($data['response'] != $valid_response)
        die('Datos Erroneos!');

    // ok, usuario & password validos
    echo 'Estas logueado como: ' . $data['username'];


    // function to parse the http auth header
    function http_digest_parse($txt)
    {
        // proteger contra datos perdidos
        $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
        $data = array();
        $keys = implode('|', array_keys($needed_parts));

        preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

        foreach ($matches as $m) {
            $data[$m[1]] = $m[3] ? $m[3] : $m[4];
            unset($needed_parts[$m[1]]);
        }

        return $needed_parts ? false : $data;
    }
    ?>

Ejemplo de Autenticación HTTP forzando a un nuevo usuario/password

::

    <?php
    function authenticate() {
        header('WWW-Authenticate: Basic realm="Test Authentication System"');
        header('HTTP/1.0 401 Unauthorized');
        echo "Debes ingresar un login ID y password validos para accesar a este recurso\n";
        exit;
    }
     
    if (!isset($_SERVER['PHP_AUTH_USER']) ||
        ($_POST['SeenBefore'] == 1 && $_POST['OldAuth'] == $_SERVER['PHP_AUTH_USER'])) {
        authenticate();
    } else {
        echo "<p>Bienvenido: " . htmlspecialchars($_SERVER['PHP_AUTH_USER']) . "<br />";
        echo "Anterior: " . htmlspecialchars($_REQUEST['OldAuth']);
        echo "<form action='' method='post'>\n";
        echo "<input type='hidden' name='SeenBefore' value='1' />\n";
        echo "<input type='hidden' name='OldAuth' value=\"" . htmlspecialchars($_SERVER['PHP_AUTH_USER']) . "\" />\n";
        echo "<input type='submit' value='Re Authenticate' />\n";
        echo "</form></p>\n";
    }
    ?>

