<?php
/**
 * Created by PhpStorm.
 * User: Andrew Kroll <andrew.kroll@bhnetwork.com>
 * Date: 4/25/18
 * Time: 8:24 AM
 */

namespace App\LegacyIndustry\Cleaner;


class StateCleaner extends BaseCleaner
{
    protected const TRANSLATION_KEY = 'state';

    private const STATES = [
        'AL', 'AK', 'AS', 'AZ', 'AR',
        'CA', 'CO', 'CT',
        'DE', 'DC',
        'FM', 'FL',
        'GA', 'GU',
        'HI',
        'ID', 'IL', 'IN', 'IA',
        'KS', 'KY',
        'LA',
        'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MP', 'MT',
        'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND',
        'OH', 'OK', 'OR',
        'PW', 'PA', 'PR',
        'RI',
        'SC', 'SD',
        'TN', 'TX',
        'UT',
        'VT', 'VI', 'VA',
        'WA', 'WV', 'WI', 'WY',
        'AE', 'AA', 'AP',
        'AB', 'BC', 'MB', 'NB', 'NL', 'NS', 'NT', 'NU', 'ON', 'PE', 'QC', 'SK', 'YT',
        'MX',
    ];

    public function clean(?string $data): ?string
    {
        $data = trim($data);

        if (empty($data)) {
            return null;
        }

        if (in_array($data, static::STATES)) {
            return $data;
        }

        if ($this->translationParser->canTranslate(static::TRANSLATION_KEY, $data)) {
            return $this->translationParser->translate(static::TRANSLATION_KEY, $data);
        }

        $this->logInabilityToClean($data);

        return $data;
    }
}