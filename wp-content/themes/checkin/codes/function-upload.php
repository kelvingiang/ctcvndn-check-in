<?php
function uploadFile($File = array(), $name = null)
{
    if (!empty($File['file_upload']['name'])) {
        $errors = array();
        $file_name = $File['file_upload']['name'];
        $file_size = $File['file_upload']['size'];
        $file_tmp = $File['file_upload']['tmp_name'];
        $file_type = $File['file_upload']['type'];

        $file_trim = ((explode('.', $File['file_upload']['name'])));
        $trim_name = strtolower($file_trim[0]);
        $trim_type = strtolower($file_trim[1]);

        $cus_name = $name . '.' . $trim_type;
        $extensions = array("jpeg", "jpg", "png", "bmp");
        if (in_array($trim_type, $extensions) === false) {
            $errors[] = "上傳照片檔案是 JPEG, PNG, BMP.";
        }
        if ($file_size > 2097152) {
            $errors[] = '上傳檔案容量不可大於 2 MB';
        }
        //$path = WP_CONTENT_DIR . DS . 'themes' . DS . '2020' . DS . 'images' . DS . 'apply' . DS; /* get function path upload img dc khai bao tai file hepler */

        if (empty($errors) == true) {

            if (is_file(DIR_IMAGES_APPLY . $name)) {
                unlink(DIR_IMAGES_APPLY . $name);
            }
            move_uploaded_file($file_tmp, (DIR_IMAGES_APPLY . $cus_name));
            return $cus_name;
        } else {
            return $errors;
        }
    }
}

function uploadImg($File = array(), $name = null)
{
    if (!empty($File['img_upload']['name'])) {
        $errors = array();
        $file_name = $File['img_upload']['name'];
        $file_size = $File['img_upload']['size'];
        $file_tmp = $File['img_upload']['tmp_name'];
        $file_type = $File['img_upload']['type'];

        $file_trim = ((explode('.', $File['img_upload']['name'])));
        $trim_type = strtolower($file_trim[1]);

        $cus_name = $File['img_upload']['name'];
        $extensions = array("jpeg", "jpg", "png", "bmp");
        if (in_array($trim_type, $extensions) === false) {
            $errors[] = "上傳照片檔案是 JPEG, PNG, BMP.";
        }
        if ($file_size > 2097152) {
            $errors[] = '上傳檔案容量不可大於 2 MB';
        }
        //$path = WP_CONTENT_DIR . DS . 'themes' . DS . '2020' . DS . 'images' . DS . 'download' . DS; /* get function path upload img dc khai bao tai file hepler */

        if (empty($errors) == true) {

            if (is_file(DIR_IMAGES_DOWNLOAD . $name)) {
                unlink(DIR_IMAGES_DOWNLOAD . $name);
            }
            move_uploaded_file($file_tmp, (DIR_IMAGES_DOWNLOAD . $cus_name));
            return $cus_name;
        } else {
            return $errors;
        }
    }
}

function uploadFileDownLoad($File = array(), $name = null)
{
    if (!empty($File['file-upload']['name'])) {
        $errors = array();
        $file_name = $File['file-upload']['name'];
        $file_size = $File['file-upload']['size'];
        $file_tmp = $File['file-upload']['tmp_name'];

        $file_trim = ((explode('.', $File['file-upload']['name'])));
        $trim_name = strtolower($file_trim[0]);
        $trim_type = strtolower($file_trim[1]);


        $cus_name = "upload-" . date("YmdHis") . '.' . $trim_type;

        if ($file_size > 100097152) {
            $errors[] = '上傳檔案容量不可大於 100 MB';
        }

        if (empty($errors) == true) {

            if (is_file(DIR_FILE . $name)) {
                unlink(DIR_FILE . $name);
            }

            move_uploaded_file($file_tmp, (DIR_FILE . $cus_name));
            return $cus_name;
        } else {
            return $errors;
        }
    }
}


function uploadFileDownLoadMore($File = array(), $oldFile = null, $stt)
{
    // if (!empty($File['file-upload']['name'])) {
    $errors = array();
    $file_name = $File['name'];
    $file_size = $File['size'];
    $file_tmp = $File['tmp_name'];

    $file_trim = ((explode('.', $File['name'])));
    $trim_name = strtolower($file_trim[0]);
    $trim_type = strtolower($file_trim[1]);


    $cus_name = "register-" . date("YmdHis").'-'. $stt . '.' . $trim_type;

    if ($file_size > 100097152) {
        $errors[] = '上傳檔案容量不可大於 100 MB';
    }

    if (empty($errors) == true) {

        if (is_file(DIR_FILE . $oldFile)) {
            unlink(DIR_FILE . $oldFile);
        }

        move_uploaded_file($file_tmp, (DIR_FILE . $cus_name));
        return $cus_name;
    } else {
        return $errors;
    }
    // }
}
