import {generateCodeVerifier, generateState} from "oslo/oauth2";
import oauth2Client from "@/components/OAuth/OAuthClient";
import {redirect} from "next/navigation";

export default async function Login() {
    const state = generateState();
    const codeVerifier = generateCodeVerifier(); // for PKCE flow
    const url = await oauth2Client.createAuthorizationURL({
        state,
        scopes: ["common"],
        codeVerifier
    });

    //window.localStorage.setItem('auth.location', window.location.pathname);
    //window.localStorage.setItem('auth.code_verifier', codeVerifier);
    //window.localStorage.setItem('auth.state', state);

    return redirect(url);
}