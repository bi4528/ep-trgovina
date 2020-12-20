package ep.rest;

import android.util.Log;

import java.io.IOException;

import okhttp3.FormBody;
import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Test {

    private static final String IMGUR_CLIENT_ID = "...";
    private static final MediaType MEDIA_TYPE_PNG = MediaType.parse("image/png");

    private final OkHttpClient client = new OkHttpClient();

    public int run(String pass, String mail)  {
        // Use the imgur image upload API as documented at https://api.imgur.com/endpoints/image
        RequestBody formBody = new FormBody.Builder()
                .add("geslo", pass)
                .add("email", mail)
                .build();
        String body = pass+"&"+mail;
        Request request = new Request.Builder()
                .url("http://192.168.1.71:8080/netbeans/ep-trgovina/api/verify/")
                .post(formBody)
                .build();
        Log.i("Http request",request.body().toString());

        try (Response response = client.newCall(request).execute()) {
            int res=response.code();
            Log.e("HTTP status:", String.valueOf(res));
            //System.out.println(response);
            if (!response.isSuccessful())
                Log.i("WTF","Neki ni kul");
            Log.e("HTTPresponse",response.body().string());
            //System.out.println(response.body().string());
            return res;
        }
        catch (Exception e){
            e.printStackTrace();
            return -1;
        }
    }


    //public int update()

}
