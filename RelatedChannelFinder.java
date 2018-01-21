import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.io.*;

import java.util.*;

/**
 * A simple example, used on the jsoup website.
 */
public class RelatedChannelFinder {
    public static void main(String[] args) throws IOException {
    	HashMap<String, String> names = new HashMap<String, String>();
    	HashMap<String, ArrayList<String>> related = new HashMap<String, ArrayList<String>>();
    	//findAllRelatedRecursive(names, related, "UC-lHJZR3Gqxm24_Vd_AJ5Yw", "PewDiePie");
    	Queue<String> q = new LinkedList<String>();
    	q.add("UC-lHJZR3Gqxm24_Vd_AJ5Yw");
    	int maxChannelsToScan = 300;
    	int channelsScanned=0;
    	while(!q.isEmpty() && channelsScanned<maxChannelsToScan) {
    		String id=q.remove();

    		Document doc = Jsoup.connect("https://www.youtube.com/channel/" + id).get();
        	Element partWithChannels = doc.children().get(0).children().get(1).children().get(12);
        	String htm = partWithChannels.html();
			int ind = htm.indexOf("miniChannelRenderer");
			//System.out.println("For channel " + id);
			ArrayList<String> relatedChannels = new ArrayList<String>();
			while(ind!=-1) {
				//System.out.println(htm.substring(ind+35, ind+150)); 
				String relatedId = htm.substring(ind+35, ind+59);
				relatedChannels.add(relatedId);
				//System.out.println(id); 
				String nameWithExtra = htm.substring(ind+87, ind+300);
                int inde = nameWithExtra.indexOf('\"');
                if(inde<0)  {
                    System.out.println(relatedId);
                    System.out.println(nameWithExtra);
                    continue;
                }
				String relatedName = nameWithExtra.substring(0, nameWithExtra.indexOf('\"'));
				//System.out.println(name);
				//System.out.println("    id: " + relatedId + " name: " + name);
				if(!names.containsKey(relatedId)) {
					names.put(relatedId, relatedName);
					q.add(relatedId);
				}
				ind = htm.indexOf("miniChannelRenderer", ind+1);
			}
			related.put(id, relatedChannels);
			//System.out.println("Finished finding related for " + id);
			if(channelsScanned % 10 ==0) {
				System.out.println("Queue size: " + q.size());
				System.out.println("Channels scanned: " + channelsScanned);
			}
			channelsScanned++;
    	}

    	writeOutputFiles(names, related);

    }

    private static void writeOutputFiles(HashMap<String, String> names, HashMap<String, ArrayList<String>> related) throws IOException{
    	/*String jsonString = "{\"nodes\":[\"";
    	for(String id:names.keySet()) {
    		name = names.get(id);
    		jsonString+= "\"caption\": \""+name+"\",\"id\": \""+id+"\"},";
    	}
    	jsonString+="}";
    	for string id:related.keySet()) {

	
    	PrintWriter namesOut = new PrintWriter(new File("names.txt"));
    	namesOut.print(names);
    	namesOut.close();
    	PrintWriter relatedOut = new PrintWriter(new File("related.txt"));
    	/*for(String id: related.keySet()) {
    		relatedOut.println(id + " " + related.get(id));
    	}*/
    	//relatedOut.print(related);
    	//relatedOut.close();
        PrintWriter namesOut = new PrintWriter(new File("names300.txt"));
        PrintWriter relatedOut = new PrintWriter(new File("related300.txt"));
        for(String id: names.keySet()) {
            namesOut.println(id + " " + names.get(id));
        }
        for(String id: related.keySet()) {
            relatedOut.println(id + " " + related.get(id));
        }
        namesOut.close();
        relatedOut.close();
    }

    private static void findThing(String soFar, Element e) {
    	if(e.id().equals("channel-info")) {
    		System.out.println("found it");
    		System.out.println(soFar);
    	}
    	Elements children = e.children();
    	if(children.size()==0) {
    		System.out.println("bottom of tree");
    		System.out.println(soFar);
    		System.out.println(e);
    	}
    	for(int i=0;i<children.size();i++) {
    		findThing(soFar + " " + i, e.child(i));
    	}
    }
}