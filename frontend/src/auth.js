import NextAuth from "next-auth"

export const {
    handlers: { GET, POST },
    auth,
} = NextAuth({
    providers: [
        {
            id: "kakao",
            name: "Kakao",
            type: "oauth2",
            authorization: "http://127.0.0.1:8080/authorize",
            token: "https://kauth.kakao.com/oauth/token",
            userinfo: "https://kapi.kakao.com/v2/user/me",
            profile(profile) {
                return {
                    id: profile.id,
                    name: profile.kakao_account?.profile.nickname,
                    email: profile.kakao_account?.email,
                    image: profile.kakao_account?.profile.profile_image_url,
                }
            },
        }
    ],
})