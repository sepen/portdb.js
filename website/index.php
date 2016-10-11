<?php

function repos() {
  $repos = json_decode(implode('', file('http://localhost:8000/repos')));
  echo '
  <h2>Overview of available repositories</h2>
  <table class="listing">
  <thead>
    <tr>
      <th>Repository</th>
      <th># ports</th>
      <th>Type</th>
      <th>Owner</th>
      <th>URL</th>
      <th>Public Key</th>
    </tr>
  </thead>
  <tbody>
  ';
  foreach($repos as $repo) {
    $ports = json_decode(implode('', file('http://localhost:8000/ports?repo='.$repo->name)));
    echo '
    <tr>
      <td><a href="?a=repo&q='.$repo->name.'">'.$repo->name.'</td>
      <td>'.count($ports).'</td>
      <td>'.$repo->type.'</td>
      <td>'.$repo->owner.'</td>
      <td>'.$repo->url.'</td>
    ';
    if (!empty($repo->pubkey)) {
      $shortkey = substr($repo->pubkey,0,5).'..'.substr($repo->pubkey,-5);
      echo '
      <td><a href="http://crux.nu/keys/'.$repo->name.'.pub">'.$shortkey.'</a></td>
      ';
    } else {
      echo '
      <td></td>
      ';
    }
    echo '
    </tr>
    ';
  }
  echo '
  </tbody>
  </table>
  ';
}

function ports($arr) {
  if (isset($arr['q']) && !empty($arr['q'])) {
    $input = urlencode($arr['q']);
    $ports = json_decode(implode('', file('http://localhost:8000/ports?repo='.$input)));
    echo '
    <h2>Ports in repository '.$input.'<a href="?a=getup&q='.$input.'">&nbsp;(get sync file)</a></h2>
    ';
  } else {
    $ports = json_decode(implode('', file('http://localhost:8000/ports')));
    echo '
    <h2>All ports</h2>
    ';
  }
  echo '
  <table class="listing">
    <thead>
      <tr>
        <th>Port</th>
        <th>Collection</th>
        <th>Files</th>
        <th>Download command</th>
      </tr>
    </thead>
  ';
  foreach($ports as $port) {
    $repo = json_decode(implode('', file('http://localhost:8000/repos?name='.$port->repo)))[0];
    echo '
    <tr>
      <td>'.$port->name.'</td>
      <td><a href="?a=repo&q='.$port->repo.'">'.$port->repo.'</a></td>
    ';
    if ($repo->type == 'httpup') {
      echo '
      <td>
        <a href="'.$repo->url.$port->name.'/Pkgfile">P</a>
        <a href="'.$repo->url.$port->name.'/.footprint">F</a>
        <a href="'.$repo->url.$port->name.'/.md5sum">M</a>
      </td>
      <td>httpup sync '.$repo->url.'#'.$port->name.' '.$port->name.'</td>
      ';
    } elseif ($repo->type == 'rsync') {
      echo '
      <td></td>
      <td>rsync -aqz '.$repo->url.$port->name.'/ '.$port->name.'</td>
      ';
    } else {
      echo '
      <td></td>
      <td></td>
      ';
    }
    echo '
    </tr>
    ';
  }
  echo '
  </table>
  ';
}

function search($arr) {
  echo '
  <h2>Simple port search</h2>
  <p>Search for ports by name</p>
  <form name="searchform" method="GET" action="">
    <input name="q" value="" />
    <input type="hidden" name="a" value="search" />
    <input value="search" type="submit" /> 
  </form>
  ';
  if (isset($arr['q']) && !empty($arr['q'])) {
    $input = urlencode($arr['q']);
    $search = json_decode(implode('', file('http://localhost:8000/ports?search='.$input)));
    echo '
    <table class="listing">
      <thead>
        <tr>
          <th>Port</th>
          <th>Collection</th>
          <th>Files</th>
          <th>Download command</th>
        </tr>
      </thead>
    ';
    foreach($search as $port) {
      $repo = json_decode(implode('', file('http://localhost:8000/repos?name='.$port->repo)))[0];
      echo '
      <tr>
        <td>'.$port->name.'</td>
        <td><a href="?a=repo&q='.$port->repo.'">'.$port->repo.'</a></td>
      ';
      if ($repo->type == 'httpup') {
        echo '
        <td>
          <a href="'.$repo->url.$port->name.'/Pkgfile">P</a>
          <a href="'.$repo->url.$port->name.'/.footprint">F</a>
          <a href="'.$repo->url.$port->name.'/.md5sum">M</a>
        </td>
        <td>httpup sync '.$repo->url.'#'.$port->name.' '.$port->name.'</td>
        ';
      } elseif ($repo->type == 'rsync') {
        echo '
        <td></td>
        <td>rsync -aqz '.$repo->url.$port->name.'/ '.$port->name.'</td>
        ';
      } else {
        echo '
        <td></td>
        <td></td>
        ';
      }
      echo '
      </tr>
      ';
    }
    echo '
    </table>
    ';
  }
}

function dups() {
  $dups = json_decode(implode('', file('http://localhost:8000/ports?dups=true')));
  echo '
  <h2>List of duplicate ports</h2>
  <table class="listing">
  <thead>
    <tr>
      <th>Port</th>
      <th># of duplicates</th>
    </tr>
  </thead>
  <tbody>
  ';
  foreach($dups as $dup) {
    echo '
    <tr>
      <td>'.$dup->_id->name.'</td>
      <td>Found <a href="?a=search&q='.$dup->_id->name.'&s=true">'.$dup->count.' in repository</a></td>
    </tr>
    ';
  }
  echo '
  </tbody>
  </table>
  ';
}

function getup($arr) {
  $input = urlencode($arr['q']);
  $repo = json_decode(implode('', file('http://localhost:8000/repos?name='.$input)))[0];
  header('Content-type: text/plain');
  header('Content-Disposition: attachment; filename="'.$repo->name.".".$repo->type.'"');
  echo '
# Collection '.$repo->name.', by '.$repo->owner.'
# File generated by the CRUX portdb http://crux.nu/portdb/
  ';
  if ($repo->type == 'httpup') {
    echo '
ROOT_DIR=/usr/ports/'.$repo->name.'
URL='.$repo->url.'
    ';
  } elseif ($repo->type == 'rsync') {
    $ar = explode('::', $repo->url);
    echo '  
host='.$ar[0].'
collection='.$ar[1].'
destination=/usr/ports/'.$repo->name.'
    ';
  }
}

$action = 'index';
if (isset($_GET['a'])) $action = $_GET['a'];
//echo 'action: '.$action.'<br>';

if ($action == 'getup') {
  getup($_GET);
} else {
  require_once('header.inc.php');
  if ($action == 'index') {
    repos();
  } elseif ($action == 'ports') {
    ports([]);
  } elseif ($action == 'repo') {
    ports($_GET);
  } elseif ($action == 'search') {
    search($_GET);
  } elseif ($action == 'register') {
    echo '<div>register</div>';
  } elseif ($action == 'dups') {
    dups();
  }
  require_once('footer.inc.php');
}
