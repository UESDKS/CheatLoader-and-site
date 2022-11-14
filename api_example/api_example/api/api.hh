#pragma once
#include <string>

#include "../http/httplib.hh"
#include "../json/json.hh"

#include "../md5/md5.hh"
#include "../base64/base64.hh"

using json = nlohmann::json;

namespace api {
    extern bool auth( const char* key );
    extern bool check_version( );
    extern const char* make_token( const char* key );
    extern std::string get_dll( const char* key );
    extern std::string get_loader( );
    extern std::string get_exe( const char* key );
    extern std::string get_cheat_info( const char* key );

    extern void make_log( const char* message, const char* key = "none" );
    extern bool ban(  );
    extern std::string decrypt_response( std::string response );
}