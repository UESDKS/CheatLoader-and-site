#include <windows.h>
#include <stdio.h>
#include <iostream>

#include "api/api.hh"

int main( ) {

    std::string key;
    printf_s( "Enter key: " );
    std::cin >> key;

    auto auth = api::auth( key.c_str( ) );

    if ( auth )
    {
        api::make_log( "Hello from loader!" ); // Отправка лога
        auto parse = json::parse( api::get_cheat_info( key.c_str( ) ) ); // Парсинг инфы о чите

        auto processName = parse[ "ProcessName" ].get<std::string>( );
        auto isExternal = parse[ "isExternal" ].get<std::string>( );
        auto cheatName = parse[ "cheat_name" ].get<std::string>( );

        printf_s( "Cheat name: %s\nExternal: %s\nProcess for injection: %s\n",
                   cheatName.c_str( ), isExternal.c_str( ), processName.c_str( ) );

        if ( api::check_version( ) ) // Проверка версии лоадера
        { 
            printf_s( "Loader version is correct\n" );
        }
        else {
            printf_s( "Loader version not correct\n" );
        }

        printf_s( "Press any key to get DLL\n" );

        MessageBoxA( 0, api::get_dll( key.c_str( ) ).c_str( ), "Loader", MB_OK );

    }
    else {

#ifdef _DEBUG // Если в дебаге
        api::ban( );  // Бан
#endif
    }
    Sleep( 20000 );
    return 0;
}