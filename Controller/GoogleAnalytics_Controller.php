<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 27-05-13
 * Time: 13:11
 * To change this template use File | Settings | File Templates.
 */

class GoogleAnalytics_Controller
{
    /**
     * @var Google_AnalyticsService
     */
    public $google_analytics;

    /**
     * @param $google_client
     */
    public function __construct($google_client)
    {
        $this->google_analytics = new Google_AnalyticsService($google_client);
    }

    /**
     * Returns a list of profiles attached to an account/property
     * When used ~all, ~all this will return a list with all profiles/accounts/proprties available to the Google account
     */
    public function listAllProfiles()
    {
        return $this->listProfiles("~all", "~all");
    }

    /**
     * Lists the profiles linked to an account/property
     */
    public function listProfiles($propertyId, $accountId)
    {
        $list = $this->listManagementProfiles($propertyId, $accountId);
        $google_analytics_profiles = array();

        if (sizeof($list['items']) > 0) {
            foreach ($list['items'] as $item) {

                $property = $item['webPropertyId'];
                $profile = $item['id'];
                $account = $item['accountId'];
                $name = $item['name'];
                $websiteUrl = $item['websiteUrl'];

                $array = array(
                    $websiteUrl => array(
                        'property' => $property,
                        'profile' => $profile,
                        'account' => $account,
                        'name' => $name
                    )
                );

                if (array_key_exists($websiteUrl, $google_analytics_profiles))
                {
                    $google_analytics_profiles[$websiteUrl][] = $array[$websiteUrl];
                }
                else
                {
                    $google_analytics_profiles[$websiteUrl][] = $array[$websiteUrl];
                }
            }

        }
        return $google_analytics_profiles;
    }

    /**
     * Lists all the accounts/properties and profiles
     */
    private function listManagementProfiles($propertyId, $accountId)
    {
        return $this->google_analytics->management_profiles->listManagementProfiles($accountId, $propertyId);
    }
}