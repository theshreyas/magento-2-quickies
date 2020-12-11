<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Theshreyas\RenameCountry\Plugin\Magento\Framework\Locale;

class TranslatedLists
{

    public function afterGetCountryTranslation(
        \Magento\Framework\Locale\TranslatedLists $subject,
        $result
    ) {
        if($value == 'United Kingdom')
        	return 'Great Britain';

        return $result;
    }
}

