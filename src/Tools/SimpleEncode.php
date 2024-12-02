<?php
/**
 * Project bear-service
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 17/8/24
 * Time: 23:00
 */

namespace Bear8421\Bear\Services\Tools;

use Bear8421\Bear\Services\API\HungNgToolsServices;
use nguyenanhung\Libraries\Slug\SlugUrl;

class SimpleEncode extends HungNgToolsServices
{
    protected function encode_alternating_case($input = ''): string
    {
        // aLtErNaTiNg cAsE
        $alternating_case = '';
        if (!empty($input)) {
            for ($i = 0; $i < strlen($input); $i++) {
                $alternating_case .= ($i % 2 == 0) ? strtolower($input[$i]) : strtoupper($input[$i]);
            }
        }
        return $alternating_case;
    }

    protected function encode_inverse_case($input = ''): string
    {
        // InVeRsE CaSe
        $inverse_case = '';
        if (!empty($input)) {
            for ($i = 0; $i < strlen($input); $i++) {
                $inverse_case .= ctype_upper($input[$i]) ? strtolower($input[$i]) : strtoupper($input[$i]);
            }
        }
        return $inverse_case;
    }

    public function encode($input, $algorithm = 'md5'): array
    {
        $supported = array(
            'md5',
            'sha1',
            'sha256',
            'sha384',
            'sha512',
            'rimed128',
            'ripemd256',
            'base64',
            'supper_base64',
            'password_hash',
            'htpasswd',
            'lower_case',
            'upper_case',
            'sentence_case',
            'capitalized_case',
            'alternating_case',
            'title_case',
            'inverse_case',
            'slugify',
        );

        $needsHash = !empty($algorithm) ? mb_strtolower($algorithm) : $algorithm;

        switch ($needsHash) {
            case "md5":
            case "sha1":
            case "sha384":
            case "sha512":
            case "rimed128":
            case "ripemd256":
                $outputContent = hash($needsHash, $input);
                break;
            case "base64":
                $outputContent = base64_encode($input);
                break;
            case "supper_base64":
                $outputContent = trim($input);
                $outputContent = base64_encode($outputContent);
                $outputContent = strrev($outputContent);
                $outputContent = base64_encode($outputContent);
                $outputContent = base64_encode($outputContent);
                $outputContent = strrev($outputContent);
                break;
            case "password_hash":
                $outputContent = password_hash($input, PASSWORD_DEFAULT);
                break;
            case "htpasswd":
                $outputContent = generateHtpasswdPassword($input);
                break;
            case "lower_case":
                $outputContent = strtolower($input);
                break;
            case "upper_case":
                $outputContent = strtoupper($input);
                break;
            case "sentence_case":
                $outputContent = ucfirst(strtolower($input));
                break;
            case "capitalized_case":
                $outputContent = ucwords(strtolower($input));
                break;
            case "alternating_case":
                $outputContent = $this->encode_alternating_case($input);
                break;
            case "title_case":
                // Title Case (Capitalizes the first letter of major words)
                $outputContent = !empty($input) ? ucwords($input) : '';
                break;
            case "inverse_case":
                $outputContent = $this->encode_inverse_case($input);
                break;
            case "slugify":
                $slug = new SlugUrl();
                $outputContent = $slug->slugify($input);
                break;
            default:
                $outputContent = 'Un supported';
        }

        return array(
            'supported' => $supported,
            'input' => $input,
            'algorithm' => $algorithm,
            'output' => $outputContent
        );
    }
}
