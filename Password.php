<?php
namespace Baze\LowerPasswordLength;

use Magento\Framework\Exception\LocalizedException;

class Password extends \Magento\Customer\Model\Customer\Attribute\Backend\Password
{
    /**
     * Min password length
     */
    const MIN_PASSWORD_LENGTH = 3; // you can set value here

    /**
     * Special processing before attribute save:
     * a) check some rules for password
     * b) transform temporary attribute 'password' into real attribute 'password_hash'
     *
     * @param \Magento\Framework\DataObject $object
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave($object)
    {
        $password = $object->getPassword();

        $length = $this->string->strlen($password);
        if ($length > 0) {
            if ($length < self::MIN_PASSWORD_LENGTH) {
                throw new LocalizedException(
                    __('Please enter a password with at least %1 characters.', self::MIN_PASSWORD_LENGTH)
                );
            }

            if (trim($password) !== $password) {
                throw new LocalizedException(__('The password can not begin or end with a space.'));
            }

            $object->setPasswordHash($object->hashPassword($password));
        }
    }

    /**
     * @deprecated 100.2.0
     * @param \Magento\Framework\DataObject $object
     * @return bool
     */
    public function validate($object)
    {
        $password = $object->getPassword();
        if ($password && $password === $object->getPasswordConfirm()) {
            return true;
        }

        return parent::validate($object);
    }
}
