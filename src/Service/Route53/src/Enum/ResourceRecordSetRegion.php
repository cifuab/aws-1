<?php

namespace AsyncAws\Route53\Enum;

final class ResourceRecordSetRegion
{
    public const AF_SOUTH_1 = 'af-south-1';
    public const AP_EAST_1 = 'ap-east-1';
    public const AP_EAST_2 = 'ap-east-2';
    public const AP_NORTHEAST_1 = 'ap-northeast-1';
    public const AP_NORTHEAST_2 = 'ap-northeast-2';
    public const AP_NORTHEAST_3 = 'ap-northeast-3';
    public const AP_SOUTHEAST_1 = 'ap-southeast-1';
    public const AP_SOUTHEAST_2 = 'ap-southeast-2';
    public const AP_SOUTHEAST_3 = 'ap-southeast-3';
    public const AP_SOUTHEAST_4 = 'ap-southeast-4';
    public const AP_SOUTHEAST_5 = 'ap-southeast-5';
    public const AP_SOUTHEAST_7 = 'ap-southeast-7';
    public const AP_SOUTH_1 = 'ap-south-1';
    public const AP_SOUTH_2 = 'ap-south-2';
    public const CA_CENTRAL_1 = 'ca-central-1';
    public const CA_WEST_1 = 'ca-west-1';
    public const CN_NORTHWEST_1 = 'cn-northwest-1';
    public const CN_NORTH_1 = 'cn-north-1';
    public const EU_CENTRAL_1 = 'eu-central-1';
    public const EU_CENTRAL_2 = 'eu-central-2';
    public const EU_NORTH_1 = 'eu-north-1';
    public const EU_SOUTH_1 = 'eu-south-1';
    public const EU_SOUTH_2 = 'eu-south-2';
    public const EU_WEST_1 = 'eu-west-1';
    public const EU_WEST_2 = 'eu-west-2';
    public const EU_WEST_3 = 'eu-west-3';
    public const IL_CENTRAL_1 = 'il-central-1';
    public const ME_CENTRAL_1 = 'me-central-1';
    public const ME_SOUTH_1 = 'me-south-1';
    public const MX_CENTRAL_1 = 'mx-central-1';
    public const SA_EAST_1 = 'sa-east-1';
    public const US_EAST_1 = 'us-east-1';
    public const US_EAST_2 = 'us-east-2';
    public const US_GOV_EAST_1 = 'us-gov-east-1';
    public const US_GOV_WEST_1 = 'us-gov-west-1';
    public const US_WEST_1 = 'us-west-1';
    public const US_WEST_2 = 'us-west-2';

    public static function exists(string $value): bool
    {
        return isset([
            self::AF_SOUTH_1 => true,
            self::AP_EAST_1 => true,
            self::AP_EAST_2 => true,
            self::AP_NORTHEAST_1 => true,
            self::AP_NORTHEAST_2 => true,
            self::AP_NORTHEAST_3 => true,
            self::AP_SOUTHEAST_1 => true,
            self::AP_SOUTHEAST_2 => true,
            self::AP_SOUTHEAST_3 => true,
            self::AP_SOUTHEAST_4 => true,
            self::AP_SOUTHEAST_5 => true,
            self::AP_SOUTHEAST_7 => true,
            self::AP_SOUTH_1 => true,
            self::AP_SOUTH_2 => true,
            self::CA_CENTRAL_1 => true,
            self::CA_WEST_1 => true,
            self::CN_NORTHWEST_1 => true,
            self::CN_NORTH_1 => true,
            self::EU_CENTRAL_1 => true,
            self::EU_CENTRAL_2 => true,
            self::EU_NORTH_1 => true,
            self::EU_SOUTH_1 => true,
            self::EU_SOUTH_2 => true,
            self::EU_WEST_1 => true,
            self::EU_WEST_2 => true,
            self::EU_WEST_3 => true,
            self::IL_CENTRAL_1 => true,
            self::ME_CENTRAL_1 => true,
            self::ME_SOUTH_1 => true,
            self::MX_CENTRAL_1 => true,
            self::SA_EAST_1 => true,
            self::US_EAST_1 => true,
            self::US_EAST_2 => true,
            self::US_GOV_EAST_1 => true,
            self::US_GOV_WEST_1 => true,
            self::US_WEST_1 => true,
            self::US_WEST_2 => true,
        ][$value]);
    }
}
