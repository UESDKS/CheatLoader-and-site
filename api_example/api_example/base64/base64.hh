#pragma once
#include <Windows.h>
#include <string>


class c_base64 {
public:
    auto encrypt( std::string data ) -> std::string;
};

inline auto base64 = new c_base64;