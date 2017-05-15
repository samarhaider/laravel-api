URL: https://shield.kookie.fit
email: cap@avengers.io
password: Assemble

> php artisan migrate

> php artisan db:seed --class=UsersDumpSeeder

> composer dump-autoload (if error in above command and rerun last command)

    
> php artisan api:docs --name API --use-version v2 --output-file api-documentation.md
> php artisan generate:modelfromtable --table=users,clients,payments,booking_client,bookings,measurements,session_types --folder=app/Models --namespace="app\Models"


https://github.com/irazasyed/jwt-auth-guard