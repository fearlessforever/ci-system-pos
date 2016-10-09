<?php

header('Content-Type:application/json');
echo isset($hasil) ? json_encode($hasil) : '';