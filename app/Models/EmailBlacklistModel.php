<?php

namespace App\Models;

class EmailBlacklistModel extends BaseModel
{
    protected $table = 'email_blacklist';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['type', 'value'];
    protected $createdField = 'created_at';

    protected $validationRules = [
        'type'  => 'required|in_list[email,domain]',
        'value' => 'required|max_length[255]',
    ];

    /**
     * Checks whether an email address or its domain is blocked.
     */
    public function isBlacklisted(string $email): bool
    {
        $email = strtolower(trim($email));
        $atPosition = strrpos($email, '@');

        if ($atPosition === false) {
            return false;
        }

        $domain = substr($email, $atPosition + 1);

        return $this->select('id')
                ->groupStart()
                ->where('type', 'email')
                ->where('value', $email)
                ->groupEnd()
                ->orGroupStart()
                ->where('type', 'domain')
                ->where('value', $domain)
                ->groupEnd()
                ->first() !== null;
    }

    /**
     * Adds an email address or domain to the blacklist.
     */
    public function addEntry(?string $type, ?string $value): bool
    {
        $type = strtolower(trim((string)$type));
        $value = strtolower(trim((string)$value));

        if (!in_array($type, ['email', 'domain'], true) || $value === '') {
            return false;
        }

        if ($type === 'email') {
            if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
                return false;
            }
        } else {
            $value = preg_replace('/^(?:\*@|@)/', '', $value);
            $value = rtrim($value, '.');

            if (filter_var($value, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) === false) {
                return false;
            }
        }

        if ($this->where('type', $type)->where('value', $value)->first() !== null) {
            return false;
        }

        return (bool)$this->insert([
            'type'  => $type,
            'value' => $value,
        ]);
    }

    /**
     * Deletes a blacklist record.
     */
    public function deleteEntry(int $id): bool
    {
        return $id > 0 && (bool)$this->delete($id);
    }

    /**
     * Finds, filters, and paginates blacklist records.
     */
    public function findAllPaginated(array $filters, int $perPage): array
    {
        if (!empty($filters['q'])) {
            $this->like('value', $filters['q']);
        }

        return $this->orderBy('id', 'DESC')->paginate($perPage);
    }
}