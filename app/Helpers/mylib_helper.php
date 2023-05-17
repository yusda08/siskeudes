<?php

function ribbon($name_page = NULL, $name_page2 = NULL)
{
    $data = $name_page;
    if ($name_page2 != '') {
        $data .= '<small> / ' . $name_page2 . '</small>';
    }
    return $data;
}

function formatDatePhp($tanggal)
{
    $date = DateTime::createFromFormat('d/m/Y', $tanggal);
    return $date->format('Y-m-d');
}

function textCapital($kalimat)
{
    return ucwords(strtolower($kalimat));
}

function sprintfNumber($number, $length = 4)
{
    return sprintf("%'.0" . $length . "s", $number);
}

function statusWarning($status = null, $ket = null)
{
    $data = '
            <div class="alert alert-warning"><h4><i class="fas fa-exclamation-triangle"></i>' . $status . '</h4>
            ' . $ket . '
        </div>';
    echo $data;
}

function statusInfo($status = null, $ket = null)
{
    return '<div class="alert alert-info"><h4><i class="fas fa-info"></i> &nbsp;' . $status . '</h4>' . $ket . '</div>';
}

function numberFormat($value, $jml = 0)
{
    return number_format($value, $jml, ',', '.');
}

function aksesLog()
{
    return session()->get('is_logined');
}

function getCsrfToken()
{
    if (!session()->csrf_token) {
        session()->csrf_token = hash('sha1', time());
    }
    return session()->csrf_token;
}

/**
 * @throws Exception
 */
function cekCsrfToken($token, $ket = 'Data Token tidak ada, Silahkan Hubungi administrator')
{
    if ($token != getCsrfToken() or !getCsrfToken() or !$token) {
        throw new Exception($ket);
    }
}

function getCsrf($type = 'hidden'): string
{
    return "<input type='$type' class='form-control' id='token' name='token' value='" . getCsrfToken() . "'>";
}

function btn_tambah($attr = '', $ket = '', $class = '', $icon = 'fa-plus')
{
    $get = getAksesMenu();
    $class .= $get['action'] == 1 ? '' : ' disabled ';
    $class .= $get['action'] == 1 ? '' : ' hidden ';
    return "<button class='btn btn-primary btn-flat $class' $attr><i class='fa $icon'></i> $ket</button>";
}

function btn_edit($attrEdt = '', $ketEdt = '', $classEdt = '', $icon = 'fa-highlighter')
{
    $get = getAksesMenu();
    $classEdt .= $get['action'] == 1 ? '' : ' disabled ';
    $classEdt .= $get['action'] == 1 ? '' : ' hidden ';
    return "<button class='btn btn-warning btn-flat btn-edit {$classEdt}' {$attrEdt}><i class='fas $icon'></i> $ketEdt</button>";
}

function btn_hapus($attrHps = '', $ketHps = '', $classHps = '', $icon = 'fa-trash')
{
    $get = getAksesMenu();
    $attr = $get['action'] == 1 ? '' : 'disabled';
    return "<button $attr class='btn btn-danger btn-flat $classHps' $attrHps><i class='fa $icon'></i> $ketHps</button>";
}

function rootApi()
{
    return "http://localhost/api_siskeudes/index.php/";
}

function count_allTable($table, $whereArray)
{
    $db = \Config\Database::connect();
    $query = $db->table($table)->where($whereArray);
    return $query->countAllResults();
}

function getAksesMenu()
{
    $db = \Config\Database::connect();
    $request = \Config\Services::request();
    $url = $request->uri->getSegment(1);
    $controller = $request->uri->getSegment(2);
    if ($controller) {
        $url .= '/' . $controller;
    }
    $akses = aksesLog();
    $builder = $db->table('menu')->join('menu_role', 'id=id_menu')->where(['kd_level' => $akses['kd_level'], 'link' => $url]);
    return $builder->get()->getRowArray();
}


function btnAction($action = '', $attrBtn = '', $labelBtn = '', $classBtn = '', $typeBtn = '', $icon = ''): string
{
    switch ($action) {
        case 'back':
            $type = 'outline-danger';
            $iconBtn = 'backward';
            break;
        case 'update':
            $type = 'outline-warning';
            $iconBtn = 'highlighter';
            break;
        case 'delete':
            $type = 'outline-danger';
            $iconBtn = 'trash';
            break;
        case 'save':
            $type = 'outline-primary';
            $iconBtn = 'save';
            break;
        case 'search':
            $type = 'outline-primary';
            $iconBtn = 'search';
            break;
        case 'posting':
            $type = 'outline-danger';
            $iconBtn = 'power-off';
            break;
        case 'print':
            $type = 'outline-warning';
            $iconBtn = 'print';
            break;
        case 'add' || 'plus':
            $type = 'outline-primary';
            $iconBtn = 'plus';
            break;
        default:
            $type = 'dark';
            $iconBtn = '';
            break;
    }
    $icon = $icon ?: $iconBtn;
    $typeBtn = $typeBtn ?: $type;
    return "<button $attrBtn class='btn btn-$typeBtn btn-sm $classBtn'><i class='fa fa-$icon me-0'></i> $labelBtn</button>";
}