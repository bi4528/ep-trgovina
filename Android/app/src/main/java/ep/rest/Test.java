package ep.rest;

import android.util.Log;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.jetbrains.annotations.NotNull;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import okhttp3.MediaType;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Test {

    private static final String IMGUR_CLIENT_ID = "...";
    private static final MediaType MEDIA_TYPE_PNG = MediaType.parse("image/png");

    private final OkHttpClient client = new OkHttpClient();

    public String run(String pass,String mail) throws Exception {
        // Use the imgur image upload API as documented at https://api.imgur.com/endpoints/image
        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("geslo", pass)
                .addFormDataPart("email", mail)
                .build();

        Request request = new Request.Builder()
                .url("http://192.168.1.71:8080/netbeans/ep-trgovina/api/verify/")
                .post(requestBody)
                .build();

        try (Response response = client.newCall(request).execute()) {
            Log.e("HTTP status:", String.valueOf(response.code()));
            System.out.println(response);
            if (!response.isSuccessful()) throw new IOException("Unexpected code " + response);
            Log.e("HTTPresponse",response.body().string());
            System.out.println(response.body().string());
            return response.body().toString();
        }
    }


}
