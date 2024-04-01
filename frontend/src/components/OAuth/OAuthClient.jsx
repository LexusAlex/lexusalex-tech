import { OAuth2Client} from "oslo/oauth2";

const authorizeEndpoint = process.env.AUTHORIZE_PATH;
const tokenEndpoint = process.env.TOKEN_PATH;
const clientId = process.env.CLIENT_ID;
const redirectUrl = process.env.REDIRECT_URL;

const oauth2Client = new OAuth2Client(clientId, authorizeEndpoint, tokenEndpoint, {
    redirectURI: redirectUrl
});
export default oauth2Client;