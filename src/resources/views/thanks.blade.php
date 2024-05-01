<html>
    <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
        </x-slot>

       
        <div class="bg-blue-400 mt-2 mb-2">会員登録ありがとうございます
        </div>
                <x-button class="mt-4">
                    {{ __('ログインする') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
</html>