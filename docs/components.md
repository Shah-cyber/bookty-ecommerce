## Blade Components

Reusable view components, their props, and usage examples.

### Buttons
- `x-primary-button`
  - Props: passthrough HTML attributes; default `type=submit`
  - Usage:
    ```blade
    <x-primary-button class="mt-2">Save</x-primary-button>
    ```
- `x-secondary-button`
  - Props: passthrough; default `type=button`
- `x-danger-button`
  - Props: passthrough; default `type=submit`

### Navigation Links
- `x-nav-link`
  - Props: `active` (bool)
  - Usage:
    ```blade
    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-nav-link>
    ```
- `x-responsive-nav-link`
  - Props: `active` (bool)

### Form Inputs
- `x-input-label`
  - Props: `value`; slot used if `value` omitted
- `x-text-input`
  - Props: `disabled` (bool, default false); supports all input attributes
- `x-input-error`
  - Props: `messages` (array|string)

Example:
```blade
<x-input-label for="email" value="Email" />
<x-text-input id="email" name="email" type="email" class="mt-1 block w-full" />
<x-input-error :messages="$errors->get('email')" class="mt-2" />
```

### Dropdown
- `x-dropdown`
  - Props: `align` (`left`|`top`|`right` default right), `width` (`48` default), `contentClasses` (string)
  - Slots: `trigger`, `content`
  - Requires Alpine.js
  - Usage:
    ```blade
    <x-dropdown align="left">
        <x-slot name="trigger">
            <button>Open</button>
        </x-slot>
        <x-slot name="content">
            <x-dropdown-link href="#">Item</x-dropdown-link>
        </x-slot>
    </x-dropdown>
    ```
- `x-dropdown-link`
  - Props: passthrough anchor attributes

### Modal
- `x-modal`
  - Props: `name` (string), `show` (bool, default false), `maxWidth` (`sm|md|lg|xl|2xl`, default `2xl`)
  - Behavior: listens for `open-modal`/`close-modal` window events with `detail` matching `name`.
  - Usage:
    ```blade
    <x-modal name="profileModal">
        <div class="p-6">Hello</div>
    </x-modal>
    <button x-data @click="$dispatch('open-modal', 'profileModal')">Open</button>
    ```

### Auth Modal
- `x-auth-modal`
  - Custom Alpine.js component embedded in `resources/views/components/auth-modal.blade.php`
  - Events: dispatch `open-auth-modal` on `document` with detail `'login'` or `'register'` to open a tab.
  - Usage:
    ```blade
    <x-auth-modal />
    <button x-data @click="$dispatch('open-auth-modal', 'register')">Sign Up</button>
    ```

### Branding
- `x-application-logo`
  - SVG logo component; accepts passthrough attributes (e.g., `class`)

