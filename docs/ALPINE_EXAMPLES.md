# Alpine.js Integration Examples

**Last Updated:** February 3, 2026  
**Alpine.js Version:** Included with Livewire 3.x

This document provides practical Alpine.js integration examples for Laravel Starter components.

---

## 📚 Table of Contents

1. [Loading States](#loading-states)
2. [Form Validation](#form-validation)
3. [Conditional Rendering](#conditional-rendering)
4. [Debounced Search](#debounced-search)
5. [Modal Patterns](#modal-patterns)
6. [Toggle Switches](#toggle-switches)
7. [Tabs Component](#tabs-component)
8. [Accordion Component](#accordion-component)
9. [Auto-Save Forms](#auto-save-forms)
10. [Image Preview](#image-preview)

---

## 🔄 Loading States

### Basic Loading State

```blade
<div x-data="{ loading: false }">
    <x-ui.buttons.primary 
        x-on:click="loading = true; await submitForm(); loading = false"
        x-bind:disabled="loading">
        <span x-show="!loading">Save</span>
        <span x-show="loading" class="flex items-center">
            <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Saving...
        </span>
    </x-ui.buttons.primary>
</div>
```

### Multiple Loading States

```blade
<div x-data="{ 
    saving: false, 
    deleting: false,
    publishing: false 
}">
    <x-ui.buttons.primary 
        x-on:click="saving = true"
        x-bind:disabled="saving">
        Save Draft
    </x-ui.buttons.primary>
    
    <x-ui.buttons.secondary 
        x-on:click="publishing = true"
        x-bind:disabled="publishing">
        Publish
    </x-ui.buttons.secondary>
    
    <x-ui.buttons.danger 
        x-on:click="deleting = true"
        x-bind:disabled="deleting">
        Delete
    </x-ui.buttons.danger>
</div>
```

---

## ✅ Form Validation

### Live Email Validation

```blade
<div x-data="{
    email: '',
    validating: false,
    valid: null,
    message: '',
    async validateEmail() {
        if (!this.email) {
            this.valid = null;
            return;
        }
        
        this.validating = true;
        try {
            const response = await fetch('/api/validate-email', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({ email: this.email })
            });
            const data = await response.json();
            this.valid = data.valid;
            this.message = data.message;
        } catch (error) {
            this.valid = false;
            this.message = 'Validation failed';
        }
        this.validating = false;
    }
}">
    <x-forms.group label="Email Address" name="email" required>
        <x-forms.text-input 
            type="email"
            name="email"
            x-model="email"
            x-on:blur="validateEmail"
            x-on:input.debounce.500ms="validateEmail"
            ::class="{
                'border-green-500 focus:border-green-500 focus:ring-green-500': valid === true,
                'border-red-500 focus:border-red-500 focus:ring-red-500': valid === false
            }"
        />
        
        <!-- Validation States -->
        <div class="mt-2 text-sm">
            <span x-show="validating" class="text-gray-500 flex items-center">
                <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Validating...
            </span>
            
            <span x-show="valid === false" class="text-red-600 flex items-center">
                <svg class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <span x-text="message"></span>
            </span>
            
            <span x-show="valid === true" class="text-green-600 flex items-center">
                <svg class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span x-text="message"></span>
            </span>
        </div>
    </x-forms.group>
</div>
```

### Password Strength Indicator

```blade
<div x-data="{
    password: '',
    strength: 0,
    getStrength() {
        if (!this.password) return 0;
        let score = 0;
        if (this.password.length >= 8) score++;
        if (this.password.length >= 12) score++;
        if (/[a-z]/.test(this.password) && /[A-Z]/.test(this.password)) score++;
        if (/\d/.test(this.password)) score++;
        if (/[^a-zA-Z\d]/.test(this.password)) score++;
        return score;
    },
    getStrengthLabel() {
        const labels = ['', 'Weak', 'Fair', 'Good', 'Strong', 'Very Strong'];
        return labels[this.strength];
    },
    getStrengthColor() {
        const colors = ['', 'text-red-600', 'text-orange-600', 'text-yellow-600', 'text-green-600', 'text-green-700'];
        return colors[this.strength];
    }
}" x-init="$watch('password', () => strength = getStrength())">
    <x-forms.group label="Password" name="password" required>
        <x-forms.text-input 
            type="password"
            name="password"
            x-model="password"
        />
        
        <!-- Strength Meter -->
        <div class="mt-2">
            <div class="flex gap-1 mb-1">
                <div class="h-2 flex-1 rounded" 
                     ::class="strength >= 1 ? 'bg-red-500' : 'bg-gray-200'"></div>
                <div class="h-2 flex-1 rounded" 
                     ::class="strength >= 2 ? 'bg-orange-500' : 'bg-gray-200'"></div>
                <div class="h-2 flex-1 rounded" 
                     ::class="strength >= 3 ? 'bg-yellow-500' : 'bg-gray-200'"></div>
                <div class="h-2 flex-1 rounded" 
                     ::class="strength >= 4 ? 'bg-green-500' : 'bg-gray-200'"></div>
                <div class="h-2 flex-1 rounded" 
                     ::class="strength >= 5 ? 'bg-green-600' : 'bg-gray-200'"></div>
            </div>
            <p class="text-sm" x-bind:class="getStrengthColor()" x-text="getStrengthLabel()"></p>
        </div>
    </x-forms.group>
</div>
```

---

## 🎭 Conditional Rendering

### Show/Hide Fields Based on Selection

```blade
<div x-data="{ 
    accountType: 'personal',
    showBusinessFields: false 
}" x-init="$watch('accountType', value => showBusinessFields = value === 'business')">
    
    <x-forms.group label="Account Type" name="account_type" required>
        <x-forms.select 
            x-model="accountType"
            name="account_type"
            :options="['personal' => 'Personal Account', 'business' => 'Business Account']"
        />
    </x-forms.group>
    
    <div x-show="showBusinessFields" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100">
        
        <x-forms.group label="Company Name" name="company_name" required>
            <x-forms.text-input name="company_name" />
        </x-forms.group>
        
        <x-forms.group label="Tax ID" name="tax_id" required>
            <x-forms.text-input name="tax_id" />
        </x-forms.group>
        
        <x-forms.group label="Business Address" name="business_address">
            <x-forms.textarea name="business_address" rows="3" />
        </x-forms.group>
    </div>
</div>
```

---

## 🔍 Debounced Search

### Live Search with Results

```blade
<div x-data="{ 
    search: '',
    results: [],
    loading: false,
    async performSearch() {
        if (!this.search || this.search.length < 2) {
            this.results = [];
            return;
        }
        
        this.loading = true;
        try {
            const response = await fetch(`/api/search?q=${encodeURIComponent(this.search)}`);
            this.results = await response.json();
        } catch (error) {
            console.error('Search failed:', error);
            this.results = [];
        }
        this.loading = false;
    }
}">
    <div class="relative">
        <x-forms.text-input 
            type="search"
            placeholder="Search..."
            x-model="search"
            x-on:input.debounce.500ms="performSearch"
        />
        
        <!-- Loading Indicator -->
        <div x-show="loading" class="absolute right-3 top-3">
            <svg class="animate-spin h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>
    
    <!-- Results Dropdown -->
    <div x-show="results.length > 0" 
         x-transition
         class="absolute z-10 mt-2 w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
        <ul class="py-2">
            <template x-for="result in results" :key="result.id">
                <li>
                    <a :href="result.url" 
                       class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                       x-text="result.title"></a>
                </li>
            </template>
        </ul>
    </div>
    
    <!-- No Results -->
    <div x-show="search.length >= 2 && results.length === 0 && !loading"
         class="text-sm text-gray-500 mt-2">
        No results found
    </div>
</div>
```

---

## 🎯 Modal Patterns

### Confirmation Dialog

```blade
<div x-data="{ selectedId: null, selectedName: '' }">
    <!-- Delete Button -->
    <x-ui.buttons.danger 
        x-on:click="
            selectedId = {{ $user->id }};
            selectedName = '{{ $user->name }}';
            $dispatch('open-modal', 'confirm-user-deletion')
        ">
        Delete User
    </x-ui.buttons.danger>
    
    <!-- Confirmation Modal -->
    <x-ui.modal name="confirm-user-deletion" focusable>
        <form 
            method="post" 
            x-bind:action="`/users/${selectedId}`"
            class="p-6">
            @csrf
            @method('delete')
            
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Delete User Account
            </h2>
            
            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                Are you sure you want to delete 
                <strong x-text="selectedName"></strong>? 
                This action cannot be undone.
            </p>
            
            <div class="mt-6 flex justify-end gap-3">
                <x-ui.buttons.secondary 
                    type="button"
                    x-on:click="$dispatch('close-modal', 'confirm-user-deletion')">
                    Cancel
                </x-ui.buttons.secondary>
                
                <x-ui.buttons.danger type="submit">
                    Delete Account
                </x-ui.buttons.danger>
            </div>
        </form>
    </x-ui.modal>
</div>
```

---

## 🎚️ Toggle Switches

### Settings Toggle with Auto-Save

```blade
<div x-data="{ 
    notifications: @json($user->notifications_enabled),
    async saveNotifications() {
        try {
            await fetch('/api/settings/notifications', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({ enabled: this.notifications })
            });
        } catch (error) {
            console.error('Save failed:', error);
            this.notifications = !this.notifications; // Revert on error
        }
    }
}" x-init="$watch('notifications', () => saveNotifications())">
    <x-forms.toggle 
        name="notifications_enabled"
        x-model="notifications"
        label="Email Notifications"
    />
</div>
```

---

## 📑 Tabs Component

```blade
<div x-data="{ activeTab: 'profile' }">
    <!-- Tab Headers -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8">
            <button
                x-on:click="activeTab = 'profile'"
                ::class="{ 
                    'border-indigo-500 text-indigo-600': activeTab === 'profile',
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'profile'
                }"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Profile
            </button>
            
            <button
                x-on:click="activeTab = 'security'"
                ::class="{ 
                    'border-indigo-500 text-indigo-600': activeTab === 'security',
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'security'
                }"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Security
            </button>
            
            <button
                x-on:click="activeTab = 'notifications'"
                ::class="{ 
                    'border-indigo-500 text-indigo-600': activeTab === 'notifications',
                    'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'notifications'
                }"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Notifications
            </button>
        </nav>
    </div>
    
    <!-- Tab Content -->
    <div class="mt-6">
        <div x-show="activeTab === 'profile'" x-transition>
            <h3 class="text-lg font-medium">Profile Settings</h3>
            <!-- Profile form here -->
        </div>
        
        <div x-show="activeTab === 'security'" x-transition>
            <h3 class="text-lg font-medium">Security Settings</h3>
            <!-- Security form here -->
        </div>
        
        <div x-show="activeTab === 'notifications'" x-transition>
            <h3 class="text-lg font-medium">Notification Preferences</h3>
            <!-- Notifications form here -->
        </div>
    </div>
</div>
```

---

## 🗂️ Accordion Component

```blade
<div x-data="{ openItem: null }">
    <!-- Accordion Item 1 -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <button
            x-on:click="openItem = openItem === 1 ? null : 1"
            class="flex justify-between items-center w-full py-4 text-left">
            <span class="font-medium">How do I reset my password?</span>
            <svg 
                class="w-5 h-5 transition-transform"
                ::class="{ 'transform rotate-180': openItem === 1 }"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div 
            x-show="openItem === 1" 
            x-collapse
            class="pb-4 text-gray-600 dark:text-gray-400">
            You can reset your password by clicking the "Forgot Password" link on the login page.
        </div>
    </div>
    
    <!-- Accordion Item 2 -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <button
            x-on:click="openItem = openItem === 2 ? null : 2"
            class="flex justify-between items-center w-full py-4 text-left">
            <span class="font-medium">How do I update my profile?</span>
            <svg 
                class="w-5 h-5 transition-transform"
                ::class="{ 'transform rotate-180': openItem === 2 }"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div 
            x-show="openItem === 2" 
            x-collapse
            class="pb-4 text-gray-600 dark:text-gray-400">
            Go to Settings > Profile to update your information.
        </div>
    </div>
</div>
```

---

## 💾 Auto-Save Forms

```blade
<div x-data="{
    content: @json($post->content),
    saving: false,
    lastSaved: null,
    async autoSave() {
        this.saving = true;
        try {
            await fetch('/api/posts/{{ $post->id }}/autosave', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({ content: this.content })
            });
            this.lastSaved = new Date();
        } catch (error) {
            console.error('Auto-save failed:', error);
        }
        this.saving = false;
    }
}" x-init="$watch('content', () => autoSave())">
    
    <x-forms.textarea 
        x-model.debounce.2000ms="content"
        rows="10"
    />
    
    <div class="mt-2 text-sm text-gray-500">
        <span x-show="saving">Saving...</span>
        <span x-show="!saving && lastSaved">
            Last saved <span x-text="new Date(lastSaved).toLocaleTimeString()"></span>
        </span>
    </div>
</div>
```

---

## 🖼️ Image Preview

```blade
<div x-data="{
    imagePreview: null,
    previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imagePreview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    },
    removeImage() {
        this.imagePreview = null;
        this.$refs.imageInput.value = '';
    }
}">
    <x-forms.group label="Profile Photo" name="photo">
        <input 
            type="file" 
            name="photo"
            accept="image/*"
            x-ref="imageInput"
            x-on:change="previewImage"
            class="hidden"
        />
        
        <div class="flex items-center gap-4">
            <!-- Preview -->
            <div class="relative">
                <img 
                    x-show="imagePreview" 
                    x-bind:src="imagePreview"
                    class="h-24 w-24 rounded-full object-cover"
                />
                <div 
                    x-show="!imagePreview"
                    class="h-24 w-24 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                
                <!-- Remove Button -->
                <button
                    type="button"
                    x-show="imagePreview"
                    x-on:click="removeImage"
                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Upload Button -->
            <x-ui.buttons.secondary 
                type="button"
                x-on:click="$refs.imageInput.click()">
                Choose Photo
            </x-ui.buttons.secondary>
        </div>
    </x-forms.group>
</div>
```

---

## 📝 Best Practices

1. **Use `x-cloak`** to prevent flash of unstyled content
2. **Use debouncing** for input events (`.debounce.500ms`)
3. **Keep state management simple** - lift state up when needed
4. **Use `x-show` for frequently toggled elements**
5. **Use `x-if` for elements that rarely change**
6. **Always handle errors** in async functions
7. **Provide loading feedback** for async operations
8. **Use transitions** for smooth UI changes
9. **Test accessibility** - keyboard navigation, ARIA labels
10. **Keep Alpine.js logic simple** - complex logic belongs in Livewire

---

**See Also:**
- [Component Documentation](COMPONENTS.md)
- [Alpine.js Official Docs](https://alpinejs.dev/)
- [Livewire Documentation](https://livewire.laravel.com/docs)

---

**Last Updated:** February 3, 2026
