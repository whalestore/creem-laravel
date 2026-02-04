<?php

namespace Creem\Resources;

use Creem\Data\Entities\LicenseEntity;
use Creem\Data\Requests\ActivateLicenseRequest;
use Creem\Data\Requests\DeactivateLicenseRequest;
use Creem\Data\Requests\ValidateLicenseRequest;

class Licenses extends Resource
{
    /**
     * Activate a license key.
     */
    public function activate(ActivateLicenseRequest $request): LicenseEntity
    {
        $response = $this->client->post('/v1/licenses/activate', $request->toArray());

        return LicenseEntity::from($response);
    }

    /**
     * Deactivate a license key.
     */
    public function deactivate(DeactivateLicenseRequest $request): LicenseEntity
    {
        $response = $this->client->post('/v1/licenses/deactivate', $request->toArray());

        return LicenseEntity::from($response);
    }

    /**
     * Validate a license key.
     */
    public function validate(ValidateLicenseRequest $request): LicenseEntity
    {
        $response = $this->client->post('/v1/licenses/validate', $request->toArray());

        return LicenseEntity::from($response);
    }
}
