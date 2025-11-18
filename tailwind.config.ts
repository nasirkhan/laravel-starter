import type { Config } from 'tailwindcss'

export default {
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./Modules/**/Resources/views/**/*.blade.php",
    "./node_modules/flowbite/**/*.js"
  ]
} satisfies Config