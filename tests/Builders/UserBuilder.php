<?php

namespace Tests\Builders;

use App\Models\User;

/**
 * Test Data Builder for User model
 *
 * Provides a fluent interface for creating test users with specific attributes.
 *
 *
 * @example
 * $user = UserBuilder::make()
 *     ->withEmail('admin@example.com')
 *     ->asAdmin()
 *     ->verified()
 *     ->create();
 */
class UserBuilder
{
    private array $attributes = [];

    private array $roles = [];

    private array $permissions = [];

    private bool $shouldVerify = false;

    public static function make(): self
    {
        return new self;
    }

    public function withName(string $name): self
    {
        $this->attributes['name'] = $name;

        return $this;
    }

    public function withEmail(string $email): self
    {
        $this->attributes['email'] = $email;

        return $this;
    }

    public function withPassword(string $password): self
    {
        $this->attributes['password'] = bcrypt($password);

        return $this;
    }

    public function withUsername(string $username): self
    {
        $this->attributes['username'] = $username;

        return $this;
    }

    public function asAdmin(): self
    {
        $this->roles[] = 'super admin';

        return $this;
    }

    public function withRole(string $role): self
    {
        $this->roles[] = $role;

        return $this;
    }

    public function withPermission(string $permission): self
    {
        $this->permissions[] = $permission;

        return $this;
    }

    public function verified(): self
    {
        $this->shouldVerify = true;
        $this->attributes['email_verified_at'] = now();

        return $this;
    }

    public function unverified(): self
    {
        $this->shouldVerify = false;
        $this->attributes['email_verified_at'] = null;

        return $this;
    }

    public function active(): self
    {
        $this->attributes['status'] = 1;

        return $this;
    }

    public function inactive(): self
    {
        $this->attributes['status'] = 0;

        return $this;
    }

    public function withMobile(string $mobile): self
    {
        $this->attributes['mobile'] = $mobile;

        return $this;
    }

    public function withGender(string $gender): self
    {
        $this->attributes['gender'] = $gender;

        return $this;
    }

    public function withDateOfBirth(string $date): self
    {
        $this->attributes['date_of_birth'] = $date;

        return $this;
    }

    public function withAvatar(string $url): self
    {
        $this->attributes['avatar'] = $url;

        return $this;
    }

    public function withLastLogin(): self
    {
        $this->attributes['last_login'] = now();

        return $this;
    }

    public function withLastIp(string $ip): self
    {
        $this->attributes['last_ip'] = $ip;

        return $this;
    }

    public function withAddress(?string $address = null): self
    {
        $this->attributes['address'] = $address ?? 'Test Address';

        return $this;
    }

    public function withBio(?string $bio = null): self
    {
        $this->attributes['bio'] = $bio ?? 'Test Bio';

        return $this;
    }

    public function withUrl(?string $url = null): self
    {
        $this->attributes['url'] = $url ?? 'https://example.com';

        return $this;
    }

    public function withUrlText(?string $urlText = null): self
    {
        $this->attributes['url_text'] = $urlText ?? 'Example';

        return $this;
    }

    /**
     * Create the user with the configured attributes.
     */
    public function create(): User
    {
        $user = User::factory()->create($this->attributes);

        if (! empty($this->roles)) {
            foreach ($this->roles as $role) {
                $user->assignRole($role);
            }
        }

        if (! empty($this->permissions)) {
            foreach ($this->permissions as $permission) {
                $user->givePermissionTo($permission);
            }
        }

        return $user->fresh();
    }

    /**
     * Create multiple users with the configured attributes.
     */
    public function count(int $count): array
    {
        $users = [];
        for ($i = 0; $i < $count; $i++) {
            $users[] = $this->create();
        }

        return $users;
    }

    /**
     * Build the user without persisting to database.
     */
    public function build(): User
    {
        return User::factory()->make($this->attributes);
    }
}
