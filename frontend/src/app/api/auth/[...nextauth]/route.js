import NextAuth from "next-auth/next";
import EmailProvider from "next-auth/providers/email";

const authHandler = NextAuth({
    pages: {
        signIn: "/auth/sign-in",
        newUser: "/auth/new-user",
        verifyRequest: "/auth/verify-request",
    },
    providers: compact([
        EmailProvider({
            ...emailToken,
            server: {
                host: privateConfig.EMAIL_SERVER_HOST,
                port: privateConfig.EMAIL_SERVER_PORT,
                auth: {
                    user: privateConfig.EMAIL_SERVER_USER,
                    pass: privateConfig.EMAIL_SERVER_PASSWORD,
                },
            },
            from: privateConfig.EMAIL_FROM,
        }),
        privateConfig.GITHUB_ID &&
        privateConfig.GITHUB_SECRET &&
        GithubProvider({
            clientId: privateConfig.GITHUB_ID,
            clientSecret: privateConfig.GITHUB_SECRET,
        }),
    ]),
});

export { authHandler as GET, authHandler as POST };