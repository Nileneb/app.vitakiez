<?php

namespace App\Enums;

enum GermanState: string
{
    case BADEN_WUERTTEMBERG = 'Baden-Württemberg';
    case BAYERN = 'Bayern';
    case BERLIN = 'Berlin';
    case BRANDENBURG = 'Brandenburg';
    case BREMEN = 'Bremen';
    case HAMBURG = 'Hamburg';
    case HESSEN = 'Hessen';
    case MECKLENBURG_VORPOMMERN = 'Mecklenburg-Vorpommern';
    case NIEDERSACHSEN = 'Niedersachsen';
    case NORDRHEIN_WESTFALEN = 'Nordrhein-Westfalen';
    case RHEINLAND_PFALZ = 'Rheinland-Pfalz';
    case SAARLAND = 'Saarland';
    case SACHSEN = 'Sachsen';
    case SACHSEN_ANHALT = 'Sachsen-Anhalt';
    case SCHLESWIG_HOLSTEIN = 'Schleswig-Holstein';
    case THUERINGEN = 'Thüringen';

    /**
     * Get all state values as array (for dropdowns)
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get state by value (case-insensitive)
     */
    public static function fromValue(string $value): ?self
    {
        foreach (self::cases() as $case) {
            if (strcasecmp($case->value, $value) === 0) {
                return $case;
            }
        }
        return null;
    }
}
