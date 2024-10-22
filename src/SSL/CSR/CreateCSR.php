<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 22/10/24
 * Time: 20:44
 */

namespace Bear8421\Bear\Services\SSL\CSR;

use Bear8421\Bear\Services\Environment;
use Bear8421\Bear\Services\Traits\Version;
use Exception;

class CreateCSR implements Environment
{
    use Version;

    private $keyLength = 2048;

    private $privateKey;
    private $csr;

    /**
     * Function setKeyLength
     *
     * @param int $keyLength
     * User: 713uk13m <dev@nguyenanhung.com>
     * Copyright: 713uk13m <dev@nguyenanhung.com>
     * @return $this
     */
    public function setKeyLength(int $keyLength = 2048): CreateCSR
    {
        $this->keyLength = $keyLength;
        return $this;
    }

    /**
     * Tạo CSR với các thông tin chủ thể.
     *
     * @param string $commonName Tên miền hoặc tên máy chủ (Bắt buộc).
     * @param string $countryCode Mã quốc gia (Bắt buộc).
     * @param string $organizationName Tên tổ chức (Bắt buộc).
     * @param string|null $state Tỉnh hoặc bang (Không bắt buộc).
     * @param string|null $locality Thành phố (Không bắt buộc).
     * @param string|null $organizationUnitName Đơn vị tổ chức (Không bắt buộc).
     * @param string|null $emailAddress Địa chỉ email (Không bắt buộc).
     * @return array Mảng chứa CSR và Private Key dưới dạng chuỗi.
     * @throws Exception
     */
    public function generateCSR(
        string $commonName,
        string $countryCode,
        string $organizationName,
        string $state = '',
        string $locality = '',
        string $organizationUnitName = '',
        string $emailAddress = ''
    ): array {
        // Thông tin chủ thể của CSR
        $dn = array(
            "commonName" => $commonName,
            "countryName" => $countryCode,
            "organizationName" => $organizationName,
        );

        // Thêm các thông tin không bắt buộc nếu có
        if (!empty($state)) {
            $dn["stateOrProvinceName"] = $state;
        }
        if (!empty($locality)) {
            $dn["localityName"] = $locality;
        }
        if (!empty($organizationUnitName)) {
            $dn["organizationalUnitName"] = $organizationUnitName;
        }
        if (!empty($emailAddress)) {
            $dn["emailAddress"] = $emailAddress;
        }

        // Tạo cặp khóa riêng
        $this->privateKey = openssl_pkey_new(array(
            "private_key_bits" => $this->keyLength,        // Độ dài khóa 2048 bits
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ));

        if (!$this->privateKey) {
            throw new Exception('Không thể tạo khóa riêng.');
        }

        // Tạo CSR với thông tin chủ thể
        $this->csr = openssl_csr_new($dn, $this->privateKey, array('digest_alg' => 'sha256'));

        if (!$this->csr) {
            throw new Exception('Không thể tạo CSR.');
        }

        // Export CSR dưới dạng chuỗi
        openssl_csr_export($this->csr, $csrString);

        // Export Private Key dưới dạng chuỗi
        openssl_pkey_export($this->privateKey, $privateKeyString);

        // Trả về mảng chứa CSR và Private Key
        return [
            'CSR' => $csrString,
            'PrivateKey' => $privateKeyString
        ];
    }
}
