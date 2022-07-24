<?php

namespace Theshreyas\WPPasswordConverter\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * Encryption model
     *
     * @var EncryptorInterface
     */
    protected $encryptor;

    /**
     * WPPassword constructor.
     *
     * @param \Magento\Framework\Encryption\EncryptorInterface $encryptor
     */
    public function __construct(
        \Magento\Framework\Encryption\EncryptorInterface $encryptor
    ) {
        $this->encryptor = $encryptor;
        $this->itoa64    = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    }

    /**
     * Compare Password against hash.
     *
     * @param String $password
     * @param String $stored_hash
     */
    public function checkPassword($password, $stored_hash)
    {
        $hash = $this->cryptPrivate($password, $stored_hash);
        if ($hash[0] === '*') {
            $hash = crypt($password, $stored_hash);
        }
        // This is not constant-time.  In order to keep the code simple,
        // for timing safety we currently rely on the salts being
        // unpredictable, which they are at least in the non-fallback
        // cases (that is, when we use /dev/urandom and bcrypt).
        return $hash === $stored_hash;
    }

    /**
     * Function cryptPrivate.
     *
     * @param String $password
     * @param String $setting
     */
    public function cryptPrivate($password, $setting)
    {
        $output = '*0';
        if (substr($setting, 0, 2) === $output) {
            $output = '*1';
        }

        $id = substr($setting, 0, 3);
        // We use "$P$", phpBB3 uses "$H$" for the same thing
        if ($id !== '$P$' && $id !== '$H$') {
            return $output;
        }

        $count_log2 = strpos($this->itoa64, $setting[3]);
        if ($count_log2 < 7 || $count_log2 > 30) {
            return $output;
        }

        $count = 1 << $count_log2;

        $salt = substr($setting, 4, 8);
        if (strlen($salt) !== 8) {
            return $output;
        }

        // We were kind of forced to use MD5 here since it's the only
        // cryptographic primitive that was available in all versions
        // of PHP in use.  To implement our own low-level crypto in PHP
        // would have resulted in much worse performance and
        // consequently in lower iteration counts and hashes that are
        // quicker to crack (by non-PHP code).
        $hash = md5($salt . $password, true);
        do {
            $hash = md5($hash . $password, true);
        } while (--$count);

        $output = substr($setting, 0, 12);
        $output .= $this->encode64($hash, 16);

        return $output;
    }

    /**
     * Function encode64
     *
     * @param String $input
     * @param Int $count
     */
    public function encode64($input, $count)
    {
        $output = '';
        $i      = 0;
        do {
            $value = ord($input[$i++]);
            $output .= $this->itoa64[$value & 0x3f];
            if ($i < $count) {
                $value |= ord($input[$i]) << 8;
            }

            $output .= $this->itoa64[($value >> 6) & 0x3f];
            if ($i++ >= $count) {
                break;
            }

            if ($i < $count) {
                $value |= ord($input[$i]) << 16;
            }

            $output .= $this->itoa64[($value >> 12) & 0x3f];
            if ($i++ >= $count) {
                break;
            }

            $output .= $this->itoa64[($value >> 18) & 0x3f];
        } while ($i < $count);

        return $output;
    }
}
