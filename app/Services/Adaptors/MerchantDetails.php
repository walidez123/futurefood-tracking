<?php

namespace App\Services\Adaptors;

class MerchantDetails
{
    public $avatar = '';

    public $name;

    public $email;

    public $storeName = '';

    public $logo = '';

    public $phone = '';

    public $website = '';

    public $merchant_id = '';

    public $storeOwnerName = '';

    public $storeId = '';

    public $accessToken = '';

    public $refreshToken = '';

    public $accessExpire = '';

    public $provider;

    public $storeType = 1;

    public function getStoreType(): int
    {
        return $this->storeType;
    }

    public function setStoreType(int $storeType): void
    {
        $this->storeType = $storeType;
    }

    /**
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param  mixed  $provider
     */
    public function setProvider($provider): void
    {
        $this->provider = $provider;
    }

    /**
     * @return null
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param  null  $avatar
     */
    public function setAvatar($avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  mixed  $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param  mixed  $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return null
     */
    public function getStoreName()
    {
        return $this->storeName;
    }

    /**
     * @param  null  $storeName
     */
    public function setStoreName($storeName): void
    {
        $this->storeName = $storeName;
    }

    /**
     * @return null
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param  null  $logo
     */
    public function setLogo($logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param  null  $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return null
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param  null  $website
     */
    public function setWebsite($website): void
    {
        $this->website = $website;
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->merchant_id;
    }

    /**
     * @param  mixed  $merchant_id
     */
    public function setMerchantId($merchant_id): void
    {
        $this->merchant_id = $merchant_id;
    }

    /**
     * @return mixed
     */
    public function getStoreOwnerName()
    {
        return $this->storeOwnerName;
    }

    /**
     * @param  mixed  $storeOwnerName
     */
    public function setStoreOwnerName($storeOwnerName): void
    {
        $this->storeOwnerName = $storeOwnerName;
    }

    /**
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * @param  mixed  $storeId
     */
    public function setStoreId($storeId): void
    {
        $this->storeId = $storeId;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param  mixed  $accessToken
     */
    public function setAccessToken($accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return null
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param  null  $refreshToken
     */
    public function setRefreshToken($refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return mixed
     */
    public function getAccessExpire()
    {
        return $this->accessExpire;
    }

    /**
     * @param  mixed  $accessExpire
     */
    public function setAccessExpire($accessExpire): void
    {
        $this->accessExpire = $accessExpire;
    }
}
