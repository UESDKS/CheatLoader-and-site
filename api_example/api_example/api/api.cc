#include "api.hh"


const char* api::make_token( const char* key ) {
    char token_buf[ 2048 ];
    SYSTEMTIME time{};
    GetSystemTime( &time );
    char time_buffer[ 1024 ];

    sprintf_s( time_buffer, "date(%02d/%02d %02d%02d)", time.wDay, time.wMonth, time.wHour, time.wMinute );
    sprintf_s( token_buf, "%s%s%s", key, "0123456789"/*¬место этого указатель на получение вашего хвида*/, time_buffer );
    auto md5_token = md5( token_buf );

    return base64->encrypt( md5_token ).c_str( );
}

bool api::auth( const char* key ) {
    httplib::Client client( "hostname" ); // Your hostname 
    char buf[ 1024 ];
    sprintf_s( buf, "method=auth&key=%s&hwid=%s", key, "0123456789" );
    if ( auto res = client.Post( "/api/api.php", buf, "application/x-www-form-urlencoded" ) )
    {
        auto parser = json::parse( api::decrypt_response( res->body ) );
        auto result = parser[ "Status" ].get<std::string>( );

        if ( strstr( result.c_str( ), api::make_token( key ) ) )
        {
            return true;
        }
        else
        {
            auto error_message = parser[ "msg" ].get<std::string>( );
            printf_s( "Error: %s\n", error_message.c_str( ) );
            Sleep( 5000 );
            return false;
        }
        return false;
    }
}

std::string api::get_loader( ) {
    httplib::Client client( "hostname" ); // Your hostname 

    char buf[ 1024 ];

    printf_s( "%s Response buffer: %s\n", __FUNCTION__, buf );

    if ( auto res = client.Post( "/api/api.php", "method=getloader", "application/x-www-form-urlencoded" ) ) {
        return api::decrypt_response( res->body );
    }
}

std::string api::get_dll( const char* key ) {
    httplib::Client client( "hostname" ); // Your hostname 

    char buf[ 1024 ];

    sprintf_s( buf, "method=dll&key=%s&hwid=%s", key, "0123456789" );

    if ( auto res = client.Post( "/api/api.php", buf, "application/x-www-form-urlencoded" ) ) {
        return api::decrypt_response( res->body );
    }
}

std::string api::get_exe( const char* key ) {
    httplib::Client client( "hostname" ); // Your hostname 

    char buf[ 1024 ];

    sprintf_s( buf, "method=exe&key=%s&hwid=%s", key, "0123456789" );

    if ( auto res = client.Post( "/api/api.php", buf, "application/x-www-form-urlencoded" ) ) {
        return api::decrypt_response( res->body );
    }
}

std::string api::get_cheat_info( const char* key ) {

    httplib::Client client( "hostname" ); // Your hostname 

    char buf[ 1024 ];
    sprintf_s( buf, "method=info&key=%s&hwid=%s", key, "0123456789" );

    if ( auto res = client.Post( "/api/api.php", buf, "application/x-www-form-urlencoded" ) ) {
        return api::decrypt_response( res->body );
    }
}

#define LOADER_VERSION "13"
bool api::check_version( )
{
    httplib::Client client( "hostname" ); // Your hostname 

    char buf[ 1024 ];
    sprintf_s( buf, "method=version&loaderver=%s", LOADER_VERSION );

    httplib::Result res = client.Post( "/api/api.php", buf, "application/x-www-form-urlencoded" );

    if ( res )
    {
        auto parsed = json::parse( api::decrypt_response( res->body ) );

        auto status = parsed[ "Status" ].get<std::string>( );

        if ( strstr( status.c_str( ), "Success" ) ) {
            return true;
        }
        else {
            return false;
        }
    }

}

void api::make_log( const char* message, const char* key ) {
    httplib::Client client( "hostname" ); // Your hostname 
    char buf[ 1024 ];
    sprintf_s( buf, "method=log&message=%s&key=%s&hwid=%s", message, key, "0123456789" );

    client.Post( "/api/api.php", buf, "application/x-www-form-urlencoded" );
}

bool api::ban( ) {
    httplib::Client client( "hostname" ); // Your hostname 
    char buf[ 1024 ];
    sprintf_s( buf, "method=ban&hwid=%s", "0123456789" );
    if ( auto res = client.Post( "/api/api.php", buf, "application/x-www-form-urlencoded" ) ) {

        return true;
    }
}

std::string api::decrypt_response( std::string response ) {
    char key[ 32 ] = { 'c','5', 'I', 'c','v','h','w','I','P','e','T','s','i','N','b','o','V','n','w','3','i','6','r','U','N','7','3','J','p','F','j','j' };
    std::string output = response;
    int i;
    for ( i = 0; i < response.size( ); i++ ) {
        output[ i ] = response[ i ] ^ key[ i % ( sizeof( key ) / sizeof( char ) ) ];
    }
    return output;
}